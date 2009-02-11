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

class OpenFriends_Peer_Consumer extends OpenFriends_Peer
{
  public function __construct($name = null, $url = null, $token = null)
  {
    $this->name = $name;
    $this->url = $url;
    $this->token = $token;
  }
}
