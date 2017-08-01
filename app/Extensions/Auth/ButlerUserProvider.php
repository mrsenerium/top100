<?php
namespace App\Extensions\Auth;

use Adldap\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Arr;
use Adldap\Laravel\Traits\ImportsUsers;

class ButlerUserProvider extends EloquentUserProvider
{
    use ImportsUsers;
    /**
     * {@inheritdoc}
     */
    public function retrieveById($identifier)
    {
        //dd($identifier);
        return $this->createModel()->newQuery()->find($identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveByCredentials(array $credentials)
    {
        if ($this->allowAutoCreate()) {
            // Get the search query for users only
            $query = $this->newAdldapUserQuery();
            // Filter the query by the username attribute
            $query->whereEquals('samaccountname', $credentials['username']);
            $user = $query->first();
            if ($user instanceof User) {
                // Try to log the user in.
              try {
                  if ($this->authenticate($credentials['username'], $credentials['password'])) {
                    // Login was successful, we'll create a new
                    // Laravel model with the Adldap user.
                    return $this->getModelFromAdldap($user);
                  }
              } catch (\Exception $e) {

              }
            }

        //dd($search);
        }

      // Login failed, try local login
      return parent::retrieveByCredentials($credentials);
    }


    /**
     * {@inheritdoc}
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        try {
            if(env('APP_ENV') === 'local')
                return true;
            return parent::validateCredentials($user, $credentials) || $this->authenticate($user->username, $credentials['password']);
        } catch (\Exception $e) {
        }
    }

    protected function allowAutoCreate()
    {
        return config('butler_auth.auto_create');
    }

    /**
     * Authenticates a user against Active Directory.
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    protected function authenticate($username, $password)
    {
        return $this->getAdldap()->auth()->attempt($username, $password);
    }


    /**
     * Creates a local User from Active Directory.
     *
     * @param User   $user
     * @param string $password
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModelFromAdldap(User $user)
    {
        //dd($user);
        $username = $user->samaccountname;
        // Make sure we retrieve the first username
        // result if it's an array.
        if (is_array($username)) {
            $username = Arr::get($username, 0);
        }
        //dd($username);
        // Try to retrieve the model from the model key and AD username.
        $model = $this->createModel()->newQuery()->where('username', $username)->first();
        //dd($model);
        // Create the model instance of it isn't found.
        if (!($model instanceof Model)) {
            $model = $this->createModel();
            $model->username = trim($username);
            $model->firstname = trim(is_array($user->givenname) ? Arr::get($user->givenname, 0) : $user->givenname);
            $model->lastname = trim(is_array($user->sn) ? Arr::get($user->sn, 0) : $user->sn);
            $model->email = trim(is_array($user->mail) ? Arr::get($user->mail, 0) : $user->mail);

            //generate random password for ldap users; they should only authenticate via ldap
            $model->password = bcrypt(str_random(24));

            $model->save();
        }
        //dd($model);
        return $model;
    }
}
