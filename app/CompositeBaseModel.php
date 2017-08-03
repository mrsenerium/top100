<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompositeBaseModel extends Model
{

    public $incrementing = false;

    /**
     * The second composite primary key for the model.
     *
     * @var string
     */
    protected $secondaryKey;

    /**
     * Override model save function to handle composite key
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $query = $this->newQueryWithoutScopes();
        //add second where for composite key
        $query->where($this->secondaryKey, '=', $this->{$this->secondaryKey});

        // If the "saving" event returns false we'll bail out of the save and return
        // false, indicating that the save failed. This provides a chance for any
        // listeners to cancel save operations if validations fail or whatever.
        if ($this->fireModelEvent('saving') === false) {
            return false;
        }

        // If the model already exists in the database we can just update our record
        // that is already in this database using the current IDs in this "where"
        // clause to only update this model. Otherwise, we'll just insert them.
        if ($this->exists) {
            $saved = $this->performUpdate($query, $options);
        }

        // If the model is brand new, we'll insert it into our database and set the
        // ID attribute on the model to the value of the newly inserted row's ID
        // which is typically an auto-increment value managed by the database.
        else {
            $saved = $this->performInsert($query, $options);
        }

        if ($saved) {
            $this->finishSave($options);
        }

        return $saved;
    }

    /**
     * Get the value of the model's key.
     *
     * @param  string  $composite
     * @return mixed
     */
    public function getKey($composite = 'primary')
    {
        return $this->getAttribute($this->getKeyName($composite));
    }

    /**
     * Get the key for the model.
     *
     * @param  string  $composite
     * @return string
     */
    public function getKeyName($composite = 'primary')
    {
        if($composite === 'secondary')
            return $this->secondaryKey;

        return $this->primaryKey;
    }

      /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new CompositeCollectionBase($models);
    }
}
