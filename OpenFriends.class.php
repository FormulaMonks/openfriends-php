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

require 'OpenFriends/Peer.class.php';
require 'OpenFriends/Peer/Consumer.class.php';
require 'OpenFriends/Peer/Provider.class.php';

class OpenFriends
{
  public static function encode(Array $attributes)
  {
    return json_encode($attributes);
  }

  public static function decode($descriptor)
  {
    return json_decode($descriptor, true);
  }
}
