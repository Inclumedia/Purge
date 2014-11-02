<?php
/**
 * An extension that adds a purge tab on each page
 *
 * @author Ã†var ArnfjÃ¶rÃ° Bjarmason <avarab@gmail.com>
 * @copyright Copyright Â© 2005, Ã†var ArnfjÃ¶rÃ° Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Purge',
	'author' => 'Ã†var ArnfjÃ¶rÃ° Bjarmason',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Purge',
	'descriptionmsg' => 'purge-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgHooks['SkinTemplateNavigation::Universal'][] = 'PurgeActionExtension::contentHook';
$wgExtensionMessagesFiles['Purge'] = $dir . 'Purge.i18n.php';

class PurgeActionExtension{
	public static function contentHook( $skin, array &$content_actions ) {
		global $wgRequest, $wgUser;

		// Use getRelevantTitle if present so that this will work on some special pages
		$title = method_exists( $skin, 'getRelevantTitle' ) ?
			$skin->getRelevantTitle() : $skin->getTitle();
		if ( $title->getNamespace() !== NS_SPECIAL && $wgUser->isAllowed( 'purge' ) ) {
			$action = $wgRequest->getText( 'action' );

			$content_actions['actions']['purge'] = array(
				'class' => $action === 'purge' ? 'selected' : false,
				'text' => wfMsg( 'purge' ),
				'href' => $title->getLocalUrl( 'action=purge' )
			);
		}

		return true;
	}
}
