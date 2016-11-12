<?php
/**
 * Plugin Name: IdeaScale
 * Plugin URI:  http://www.chrisabernethy.com/wordpress-plugins/ideascale/
 * Description: Integrate IdeaScale crowdsourcing into WordPress without having to directly edit any template code.
 * Version:     1.3
 * Author:      Chris Abernethy
 * Author URI:  http://www.chrisabernethy.com/
 * 
 * Copyright 2008 Chris Abernethy
 *
 * This file is part of IdeaScale.
 * 
 * IdeaScale is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * IdeaScale is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with IdeaScale.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

// Include all class files up-front so that we don't have to worry about the
// include path or any globals containing the plugin base path.

require_once 'lib/IdeaScale/Structure.php';
require_once 'lib/IdeaScale/Structure/Options.php';
require_once 'lib/IdeaScale/Structure/View.php';
require_once 'lib/IdeaScale.php';

// Run the plugin.
IdeaScale::run(__FILE__);

/* EOF */