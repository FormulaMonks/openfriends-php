<?php

/**
 * An implementation of the OpenFriends API
 *
 * Copyright 2009, Erik Osterman <e@osterman.com>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright           Copyright 2009, Erik Osterman <e@osterman.com>
 * @author              Erik Osterman <e@osterman.com>
 * @link                http://www.getopenfriends.com/ OpenFriends
 * @package             OpenFriends
 * @version             $Revision$
 * @modifiedby          $LastChangedBy$
 * @lastmodified        $Date$
 * @license             http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class OpenFriends_Peer extends OpenFriends implements Serializable
{
  protected $attributes;

  public function __construct($descriptor, Array $options = Array())
  {
    $this->unserialize($descriptor);
    $this->merge($options);
  }

  public function __get($attribute)
  {
    return $this->getAttribute($attribute);
  }

  public function __set($attribute, $value)
  {
    return $this->setAttribute($attribute, $value);
  }

  public function __toString()
  {
    return $this->descriptor();
  }

  public function merge(Array $options)
  {
    $this->attributes = array_merge($this->attributes, $options);
  }

  public function serialize()
  {
    return $this->descriptor();
  }

  public function unserialize($descriptor)
  {
    $attributes = OpenFriends::decode($descriptor);
    if(is_array($attributes))
      $this->attributes = $attributes;
    else
      $this->attributes = Array();
  }

  public function getAttribute($attribute)
  {
    if(isset($this->attributes[$attribute]))
      return $this->attributes[$attribute];
    else
      return null;
  }

  public function setAttribute($attribute, $value)
  {
    return $this->attributes[$attribute] = $value;
  }

  public function descriptor()
  {
    return OpenFriends::encode($this->attributes);
  }

  // Sends the parameters to the consumer. Returns the response if the process
  // was successful, nil otherwise.
  public function performHttpPost($uri, $params, $timeout = 10)
  {
    try {
      $ch = curl_init();    // Starts the curl handler 
      curl_setopt($ch, CURLOPT_URL, (string)$uri); // Sets the paypal address for curl 
      curl_setopt($ch, CURLOPT_FAILONERROR, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Returns result to a variable instead of echoing 
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
      curl_setopt($ch, CURLOPT_MAXREDIRS, 10);  // Max redirects
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // Sets a time limit for curl in seconds (do not set too low) 
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_POST, true);                                   
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      curl_setopt($ch, CURLOPT_USERAGENT, get_class($this));
      $result = curl_exec($ch); 
      $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE );
      if($status_code!=200 && $status_code != 302 )
        throw new Exception((curl_error($ch) == ''? $status_code . ' Error' : curl_error($ch)), $status_code);
      curl_close($ch);
      return $result;
    } catch( Exception $e )
    {
      if(isset($ch))
        curl_close($ch);
      throw $e;
    }
  }

  public function send(OpenFriends_Peer_Consumer $consumer, $contacts)
  {
    $post = Array('provider' => (string)$this,
                  'consumer' => (string)$consumer,
                  'contacts' => (string)$contacts);
    return $this->performHttpPost($consumer->url, $post); 
  }
}
