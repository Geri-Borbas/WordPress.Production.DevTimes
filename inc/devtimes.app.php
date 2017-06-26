<?php

define('APP_DETAILS', '_app_details');

function register_app()
{
    register_post_type('app', array
    (
        'label'               => __('Apps', 'twentyseventeen'),
        'description'         => __('Applications', 'twentyseventeen'),

        // UI.
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-tablet',
        'labels'              => array
        (
            'name'                => _x('Apps', 'Application General Name', 'twentyseventeen'),
            'singular_name'       => _x('App', 'Application Singular Name', 'twentyseventeen'),
            'menu_name'           => __('Apps', 'twentyseventeen'),
            'parent_item_colon'   => __('Parent App', 'twentyseventeen'),
            'all_items'           => __('All Apps', 'twentyseventeen'),
            'view_item'           => __('View App', 'twentyseventeen'),
            'add_new_item'        => __('Add New App', 'twentyseventeen'),
            'add_new'             => __('Add New', 'twentyseventeen'),
            'edit_item'           => __('Edit App', 'twentyseventeen'),
            'update_item'         => __('Update App', 'twentyseventeen'),
            'search_items'        => __('Search App', 'twentyseventeen'),
            'not_found'           => __('Not Found', 'twentyseventeen'),
            'not_found_in_trash'  => __('Not found in Trash', 'twentyseventeen'),
        ),

        // Features.
        'supports'            => array
        (
            'title',
            // 'editor',
            'author',
            'thumbnail',
            // 'excerpt',
            // 'trackbacks',
            // 'custom-fields',
            'comments',
            'revisions',
        ),

        // Attributes.
        'public'              => true,
        'taxonomies'          => array('category', 'post_tag'),
        'has_archive'         => true,

        // Admin.
        'register_meta_box_cb' => 'add_app_metabox'
    ));
}

function include_custom_post_types($query)
{
    $custom_post_type = get_query_var('post_type');

    if (is_archive())
    { if (empty($custom_post_type)) $query->set('post_type', get_post_types()); }

    if (is_search())
    {
        if (empty($custom_post_type))
        {
            $query->set('post_type', array
                (
                    'post',
                    'page',
                    'app'
                )
            );
        }
    }

    return $query;
}
add_filter('pre_get_posts', 'include_custom_post_types');

// From http://wptheming.com/2010/08/custom-metabox-for-post-type/
function add_app_metabox()
{
    add_meta_box(
        'devtimes_app_details',
        'App Details',
        'devtimes_render_app_metabox',
        'app',
        'normal', // 'side',
        'high');
}

// Details meta box.
function devtimes_render_app_metabox()
{
    global $post;

    // Noncename needed to verify where the data originated.
    echo '<input type="hidden" name="games_details_noncename" id="games_details_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__)).'" />';

    // Get data if its already been entered.
    $gameDetailsJSON = get_post_meta($post->ID, APP_DETAILS, true); // Single entry
    $gameDetails = json_decode($gameDetailsJSON, true); // Associative array

    // Render fields.
    Timber::render('devtimes.app.metabox.twig', $gameDetails);
}

// Save.
function devtimes_save_app_meta($post_id, $post)
{
    // Only if coming from meta box.
    if (!wp_verify_nonce( $_POST['games_details_noncename'], plugin_basename(__FILE__))) return $post->ID;

    // Only if authenticated.
    if (!current_user_can('edit_post', $post->ID)) return $post->ID;

    // Assemble payload.
    $gameDetails = array();
    foreach($_POST as $eachKey => $eachValue)
    {
        if (strpos($eachKey, APP_DETAILS) === 0) // Only if GAME_DETAILS prefixed key
        {
            $extractedKey = str_replace(APP_DETAILS.'_' ,'' ,$eachKey);
            $gameDetails[$extractedKey] = $eachValue;
        }
    }

    $gameDetailsJSON = wp_json_encode($gameDetails);

    // UPDATE.
    if(get_post_meta($post->ID, APP_DETAILS, true))
    { update_post_meta($post->ID, APP_DETAILS, $gameDetailsJSON); }

    // CREATE.
    else
    { add_post_meta($post->ID, APP_DETAILS, $gameDetailsJSON); }

    // DELETE.
    if (!$_POST[APP_DETAILS]) delete_post_meta($post->ID, APP_DETAILS); // if no data in POST
}

// Hook up saving.
add_action('init', 'register_app', 0);
add_action('save_post', 'devtimes_save_app_meta', 1, 2); // Save the custom meta fields

// https://itunes.apple.com/lookup?id=1057889290
$json =
'
{
	"resultCount": 1,
	"results": [{
		"screenshotUrls": ["http://a5.mzstatic.com/us/r30/Purple69/v4/85/d9/6f/85d96fbf-5039-0823-7242-c39c6d61b09f/screen1136x1136.jpeg", "http://a1.mzstatic.com/us/r30/Purple49/v4/45/86/29/45862924-2ddf-a1c3-53bd-3fb9bf9e1995/screen1136x1136.jpeg", "http://a3.mzstatic.com/us/r30/Purple49/v4/f8/3f/29/f83f29ff-7f18-7360-6eb7-c07fdf7d1cdd/screen1136x1136.jpeg", "http://a2.mzstatic.com/us/r30/Purple69/v4/a6/af/22/a6af2219-f4dc-2f87-1d4a-8c00cc32dc42/screen1136x1136.jpeg", "http://a3.mzstatic.com/us/r30/Purple69/v4/ce/23/52/ce23524f-6fa8-3d3b-f502-63e3fdf01ee8/screen1136x1136.jpeg"],
		"ipadScreenshotUrls": ["http://a2.mzstatic.com/us/r30/Purple49/v4/6c/34/8f/6c348f9b-7474-b06c-9e2d-f8502f28e212/screen480x480.jpeg", "http://a2.mzstatic.com/us/r30/Purple69/v4/40/f2/83/40f2838b-d509-f241-70ce-ddc4338933c2/screen480x480.jpeg", "http://a3.mzstatic.com/us/r30/Purple69/v4/86/95/5f/86955f23-67a4-5c30-cf51-aa07f8ee68cc/screen480x480.jpeg", "http://a4.mzstatic.com/us/r30/Purple49/v4/7f/1f/b6/7f1fb624-6ed0-0a8f-2788-8f8eea9d8631/screen480x480.jpeg", "http://a1.mzstatic.com/us/r30/Purple49/v4/c3/6f/a7/c36fa753-5705-cc84-314a-e7223dfd8975/screen480x480.jpeg"],
		"artworkUrl60": "http://is2.mzstatic.com/image/thumb/Purple49/v4/68/1d/f2/681df2ea-34a4-5d51-fdc5-eab0d494bb3a/source/60x60bb.jpg",
		"artworkUrl512": "http://is2.mzstatic.com/image/thumb/Purple49/v4/68/1d/f2/681df2ea-34a4-5d51-fdc5-eab0d494bb3a/source/512x512bb.jpg",
		"artworkUrl100": "http://is2.mzstatic.com/image/thumb/Purple49/v4/68/1d/f2/681df2ea-34a4-5d51-fdc5-eab0d494bb3a/source/100x100bb.jpg",
		"artistViewUrl": "https://itunes.apple.com/us/developer/happymagenta/id417992534?uo=4",
		"kind": "software",
		"features": ["gameCenter", "iosUniversal"],
		"supportedDevices": ["iPhone4", "iPad2Wifi", "iPad23G", "iPhone4S", "iPadThirdGen", "iPadThirdGen4G", "iPhone5", "iPodTouchFifthGen", "iPadFourthGen", "iPadFourthGen4G", "iPadMini", "iPadMini4G", "iPhone5c", "iPhone5s", "iPhone6", "iPhone6Plus", "iPodTouchSixthGen"],
		"advisories": ["Infrequent/Mild Cartoon or Fantasy Violence"],
		"isGameCenterEnabled": true,
		"trackCensoredName": "Tomb of the Mask",
		"languageCodesISO2A": ["EN"],
		"fileSizeBytes": "33643908",
		"sellerUrl": "http://happymagenta.com/",
		"contentAdvisoryRating": "9+",
		"averageUserRatingForCurrentVersion": 4.5,
		"userRatingCountForCurrentVersion": 1236,
		"trackViewUrl": "https://itunes.apple.com/us/app/tomb-of-the-mask/id1057889290?mt=8&uo=4",
		"trackContentRating": "9+",
		"minimumOsVersion": "7.0",
		"formattedPrice": "Free",
		"currency": "USD",
		"wrapperType": "software",
		"version": "1.1",
		"artistId": 417992534,
		"artistName": "Happymagenta",
		"genres": ["Games", "Puzzle", "Arcade"],
		"price": 0.00,
		"description": "\"Tomb of the Mask instantly got me hooked with its appealing combination of retro-style graphics, fast-paced gameplay, and dead-simple controls. In fact, if I didn’t have to write this post, I probably wouldn’t have stopped from playing it\" - AppAdvice\n\n\"I\'m very impressed with how much I\'m enjoying Tomb of the Mask\" -  TouchArcade\n\n\"This modern arcade title charms with retro FX and visual sensibilities that communicate personality more than merely nostalgia\" - Kill Screen \n\n\"A challenging endless arcade game through trap-filled tombs\" - Pocket Gamer\n\nTomb of the Mask is an arcade game, which takes place in an infinite procedurally generated vertical labyrinth. Seeking for adventure you get into a tomb, where you find a strange mask. You wear it and suddenly realize that you can now climb walls - easily and promptly. And that\'s when all the fun begins. \n\nYou\'ll face a variety of traps, enemies, game mechanics and powerups. And as far as time doesn\'t wait, get a grip and up you go!",
		"trackId": 1057889290,
		"trackName": "Tomb of the Mask",
		"bundleId": "com.happymagenta.fromcore",
		"releaseDate": "2016-02-09T21:11:59Z",
		"primaryGenreName": "Games",
		"isVppDeviceBasedLicensingEnabled": true,
		"currentVersionReleaseDate": "2016-03-06T04:16:54Z",
		"releaseNotes": "- fresh content added:\n• 5 new character masks\n• portals\n• new maze sections\n• \"Score Booster\" powerup\n• free wheel of fortune spins\n• new wall colors\n• new bonus level\n• new \"Double Coins\" IAP\n- works properly on iPhone 4 now\n- improved UI\n- minor bug fixes",
		"sellerName": "Happymagenta Ltd.",
		"primaryGenreId": 6014,
		"genreIds": ["6014", "7012", "7003"],
		"averageUserRating": 4.5,
		"userRatingCount": 5730
	}]
}
';


// "screenshotUrls": ["http://a5.mzstatic.com/us/r30/Purple69/v4/85/d9/6f/85d96fbf-5039-0823-7242-c39c6d61b09f/screen1136x1136.jpeg", "http://a1.mzstatic.com/us/r30/Purple49/v4/45/86/29/45862924-2ddf-a1c3-53bd-3fb9bf9e1995/screen1136x1136.jpeg", "http://a3.mzstatic.com/us/r30/Purple49/v4/f8/3f/29/f83f29ff-7f18-7360-6eb7-c07fdf7d1cdd/screen1136x1136.jpeg", "http://a2.mzstatic.com/us/r30/Purple69/v4/a6/af/22/a6af2219-f4dc-2f87-1d4a-8c00cc32dc42/screen1136x1136.jpeg", "http://a3.mzstatic.com/us/r30/Purple69/v4/ce/23/52/ce23524f-6fa8-3d3b-f502-63e3fdf01ee8/screen1136x1136.jpeg"],
// "ipadScreenshotUrls": ["http://a2.mzstatic.com/us/r30/Purple49/v4/6c/34/8f/6c348f9b-7474-b06c-9e2d-f8502f28e212/screen480x480.jpeg", "http://a2.mzstatic.com/us/r30/Purple69/v4/40/f2/83/40f2838b-d509-f241-70ce-ddc4338933c2/screen480x480.jpeg", "http://a3.mzstatic.com/us/r30/Purple69/v4/86/95/5f/86955f23-67a4-5c30-cf51-aa07f8ee68cc/screen480x480.jpeg", "http://a4.mzstatic.com/us/r30/Purple49/v4/7f/1f/b6/7f1fb624-6ed0-0a8f-2788-8f8eea9d8631/screen480x480.jpeg", "http://a1.mzstatic.com/us/r30/Purple49/v4/c3/6f/a7/c36fa753-5705-cc84-314a-e7223dfd8975/screen480x480.jpeg"],
// "artworkUrl60": "http://is2.mzstatic.com/image/thumb/Purple49/v4/68/1d/f2/681df2ea-34a4-5d51-fdc5-eab0d494bb3a/source/60x60bb.jpg",
// "artworkUrl512": "http://is2.mzstatic.com/image/thumb/Purple49/v4/68/1d/f2/681df2ea-34a4-5d51-fdc5-eab0d494bb3a/source/512x512bb.jpg",
// "artworkUrl100": "http://is2.mzstatic.com/image/thumb/Purple49/v4/68/1d/f2/681df2ea-34a4-5d51-fdc5-eab0d494bb3a/source/100x100bb.jpg",
// "artistViewUrl": "https://itunes.apple.com/us/developer/happymagenta/id417992534?uo=4",

// "trackName": "Tomb of the Mask",
// "trackCensoredName": "Tomb of the Mask",
// "trackId": 1057889290,

// "trackViewUrl": "https://itunes.apple.com/us/app/tomb-of-the-mask/id1057889290?mt=8&uo=4",

// "formattedPrice": "Free",
// "currency": "USD",

// "releaseDate": "2016-02-09T21:11:59Z",
// "currentVersionReleaseDate": "2016-03-06T04:16:54Z",

// "artistName": "Happymagenta",
// "sellerName": "Happymagenta Ltd.",
// "sellerUrl": "http://happymagenta.com/",

// "averageUserRatingForCurrentVersion": 4.5,
// "userRatingCountForCurrentVersion": 1236,

// "averageUserRating": 4.5,
// "userRatingCount": 5730