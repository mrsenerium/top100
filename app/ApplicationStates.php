<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationStates extends Model
{
    const Closed = 1;
    const Nominations = 2;
    const ApplicationsOnly = 3;
    const ApplicationsClosed = 4;
    const Round1Judging = 5;
    const Round1Closed = 6;
    const Round2Open = 7;
    const Round2Judging = 8;
    const Round2Closed = 9;

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
   public $timestamps = false;

    /**
     * Set the state's description.
     *
     * @param  string  $value
     * @return string
     */
    public function setDescription($value)
    {
        //clean with html purifier
        $this->attributes['description'] = clean($value);
    }
    /**
     * Set the state's help text.
     *
     * @param  string  $value
     * @return string
     */
    public function setHelpText($value)
    {
        //clean with html purifier
        $this->attributes['help_text'] = clean($value);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'help_text'];
}
