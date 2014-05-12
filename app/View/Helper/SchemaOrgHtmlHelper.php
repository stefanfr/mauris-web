<?php

App::uses('AppHelper', 'View/Helper');
App::uses('BoostCakeHtmlHelper', 'BoostCake.View/Helper');

class SchemaOrgHtmlHelper extends BoostCakeHtmlHelper {
    
    /**
 * Adds a link to the breadcrumbs array.
 *
 * @param string $name Text for link
 * @param string $link URL for link (if empty it won't be a link)
 * @param string|array $options Link attributes e.g. array('id' => 'selected')
 * @return void
 * @see HtmlHelper::link() for details on $options that can be used.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#creating-breadcrumb-trails-with-htmlhelper
 */
    public function addCrumbToBeginning($name, $link = null, $options = null) {
        array_unshift($this->_crumbs, array($name, $link, $options));
    }
 
    /**
 * Returns breadcrumbs as a (x)html list
 *
 * This method uses HtmlHelper::tag() to generate list and its elements. Works
 * similar to HtmlHelper::getCrumbs(), so it uses options which every
 * crumb was added with.
 *
 * ### Options
 * - `separator` Separator content to insert in between breadcrumbs, defaults to ''
 * - `firstClass` Class for wrapper tag on the first breadcrumb, defaults to 'first'
 * - `lastClass` Class for wrapper tag on current active page, defaults to 'last'
 *
 * @param array $options Array of html attributes to apply to the generated list elements.
 * @param string|array|boolean $startText This will be the first crumb, if false it defaults to first crumb in array. Can
 *   also be an array, see `HtmlHelper::getCrumbs` for details.
 * @return string breadcrumbs html list
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#creating-breadcrumb-trails-with-htmlhelper
 */
	public function getCrumbList($options = array(), $startText = false) {
		$defaults = array('firstClass' => 'first', 'lastClass' => 'last', 'separator' => '');
		$options = array_merge($defaults, (array)$options);
		$firstClass = $options['firstClass'];
		$lastClass = $options['lastClass'];
		$separator = $options['separator'];
		unset($options['firstClass'], $options['lastClass'], $options['separator']);

		$crumbs = $this->_prepareCrumbs($startText);
		if (empty($crumbs)) {
			return null;
		}

		$result = '';
		$crumbCount = count($crumbs);
		$ulOptions = $options;
		foreach ($crumbs as $which => $crumb) {
			$options = array();
                        $options['itemprop'] = 'breadcrumb';
			if (empty($crumb[1])) {
				$elementContent = $crumb[0];
			} else {
				$elementContent = $this->link($crumb[0], $crumb[1], $crumb[2]);
			}
			if (!$which && $firstClass !== false) {
				$options['class'] = $firstClass;
			} elseif ($which == $crumbCount - 1 && $lastClass !== false) {
				$options['class'] = $lastClass;
			}
			if (!empty($separator) && ($crumbCount - $which >= 2)) {
				$elementContent .= $separator;
			}
			$result .= $this->tag('li', $elementContent, $options);
		}
		return $this->tag('ul', $result, $ulOptions);
	}
    
}