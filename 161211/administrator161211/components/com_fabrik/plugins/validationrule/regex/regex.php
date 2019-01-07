<?php
/**
*
* @package fabrikar
* @author Rob Clayburn
* @copyright (C) Rob Clayburn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/


/**
 * this is an example plugin validation rule.
 * To create a new validation rule from this example
 * 1) Copy the folder 'example' and the three files it containts (example.php, example.xml, index.html)
 * 2) Rename the folder and the php and xml file to the name of your plugin
 * e.g.
 * isurl, isurl.php and isurl.xml
 * 3) Edit isurl.xml and change the data to match your details, theer are 2 essential lines to change:
 *
 * a) <name>Example</name>
 * b) <filename fabrikplugin="example">example.php</filename>
 *
 * for these two lines replace 'example' with the name of your plugin, e.g.
 * a) <name>IsUrl</name>
 * b) <filename fabrikplugin="isurl">isurl.php</filename>
 *
 * 4) In the php file (e.g. isurl.php) , edit the lines:
 *
 * var $_pluginName = 'example';
 * var $_className = 'example';
 *
 * replacing 'example' with your plugin's name.
 *
 * 5) No to the heart of the matter - the validation itself. This takes place inside the validate() function
 * 2 variables are passed to this function:
 *
 * i) $data - the data entered in the form
 * ii) $element - the element model that the validation rule has been attached to
 *
 * You will generally only need to run your test against the $data variable.
 *
 * The validate() function should return true or false. True for when the data meets the rule's criteria
 * False for when it fails. For our 'isurl' example a fail would occur if the person had not entered a url
 * Alter the validation function to suit your own needs.
 *
 * 6) Installation - make a zip file of your validation rule's folder (e.g. 'isurl')
 * Go to your site's administration panel and select components->fabrik->plugins
 * press the install button
 * from the file upload field, browse to find your zip file.
 * Press the upload button
 *
 *
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

//require the abstract plugin class
require_once(COM_FABRIK_FRONTEND.DS.'models'.DS.'plugin.php');
require_once(COM_FABRIK_FRONTEND.DS.'models'.DS.'validation_rule.php');

class FabrikModelRegex extends FabrikModelValidationRule {

	var $_pluginName = 'regex';

	/** @param string classname used for formatting error messages generated by plugin */
	var $_className = 'notempty regex';

	/**
	 * validate the elements data against the rule
	 * @param string data to check
	 * @param object element
	 * @param int plugin sequence ref
	 * @param int repeat group count
	 * @return bol true if validation passes, false if fails
	 */

	function validate($data, &$element, $c, $repeat_count = 0)
	{
		//for multiselect elements
		if (is_array($data)) {
			$data = implode('', $data);
		}
		$params =& $this->getParams();
		$domatch = $params->get('regex-match', '_default','array', $c);
		$domatch = $domatch[$c];
		if ($domatch) {
			$v = $params->get('regex-expression', '_default','array', $c);
			$found = preg_match($v[$c], $data, $matches);
			return $found;
		}
		return true;
	}

	/**
	 *  renders admin settings
	 */

	function renderAdminSettings($elementId, &$row, &$params, $c)
	{
 		$params->_counter_override = $this->_counter;
 		$display =  ($this->_adminVisible) ? "display:block" : "display:none";
 		$return = '<div class="page-' . $elementId . ' validationSettings" style="' . $display . '">'
 		. $params->render('params', '_default', false, $c);
		$return .= '</div>';
 		$return = str_replace("\r", "", $return);
	  return $return;
	  //dont do here as if we json enocde it as we do in admin form view things go wrong
		//return  addslashes(str_replace("\n", "", $return));
 	}

 	function replace($data, &$element, $c, $repeat_count = 0)
 	{

 		$params =& $this->getParams();
		$domatch = $params->get('regex-match', '_default','array', $c);
		$domatch = $domatch[$c];
		if (!$domatch) {
	 		$v = $params->get($this->_pluginName .'-expression', '_default', 'array', $c);
			$replace = $params->get('regex-replacestring', array(), 'array', $c);
			$return = preg_replace($v[$c], JArrayHelper::getValue($replace, $c, ''), $data);
			return $return;
		}
		return $data;
 	}
}
?>