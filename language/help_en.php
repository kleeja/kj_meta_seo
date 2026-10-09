<?php
//
// kj_meta_seo, its guide on the help page of the control panel
// English
//
// The guide is built by the admin_help_guides hook in init.php, the texts here can have HTML.
//  - a list is numbered: KJ_META_SEO_HELP_TIP_1, KJ_META_SEO_HELP_TIP_2 ... it ends at the first missing number,
//    so an item can be added or removed without touching the code
//  - KJ_META_SEO_HELP_{LIST}_TITLE is the title of the list, a list without it takes the title that Kleeja gives its type
//  - questions and answers are KJ_META_SEO_HELP_FAQ_Q_1 and KJ_META_SEO_HELP_FAQ_A_1
//  - names in <strong> are written as the control panel shows them: the words of Kleeja are in lang/en/,
//    the words of the plugin in kj_meta_seo_translations() of init.php
//

return [
    'KJ_META_SEO_HELP_TITLE' => 'Meta SEO',
    'KJ_META_SEO_HELP_INTRO' =>
        'Describe your site to search engines and social networks. The plugin adds a description and keywords to the head of every page, with Open Graph and X (Twitter) Card tags that give shared links a title, a description and an image.',

    //
    // what the plugin does
    //
    'KJ_META_SEO_HELP_FEATURE_1' => 'The home page gets the description and the keywords that you write.',
    'KJ_META_SEO_HELP_FEATURE_2' =>
        'Download pages take their description and keywords from the file name, and the other pages, like <strong>Terms</strong> or <strong>Contact Us</strong>, from their title.',
    'KJ_META_SEO_HELP_FEATURE_3' =>
        'Open Graph tags (<code>og:title</code>, <code>og:description</code>, <code>og:image</code>, <code>og:url</code> and <code>og:site_name</code>) for Facebook, WhatsApp, LinkedIn, Telegram and the other apps that preview links.',
    'KJ_META_SEO_HELP_FEATURE_4' =>
        'X (Twitter) Card tags of the <code>summary</code> type: a small card with the preview image beside the title and the description.',
    'KJ_META_SEO_HELP_FEATURE_5' => 'Keywords are built from the words of the title in any language, Arabic included.',

    //
    // how to use it
    //
    'KJ_META_SEO_HELP_STEP_TITLE' => 'Set up the tags',
    'KJ_META_SEO_HELP_STEP_1' => 'Open <strong>Settings</strong>, then <strong>Meta SEO settings</strong>.',
    'KJ_META_SEO_HELP_STEP_2' =>
        'Write the <strong>Home page description</strong> and the <strong>Home page keywords</strong>.',
    'KJ_META_SEO_HELP_STEP_3' =>
        'Choose the pages and the tags you want with <strong>Generate tags for the other pages</strong>, <strong>Generate tags for download pages</strong>, <strong>Add Open Graph tags</strong> and <strong>Add X (Twitter) Card tags</strong>.',
    'KJ_META_SEO_HELP_STEP_4' =>
        'Put your preview image in the <code>images</code> folder of Kleeja, and write its file name in <strong>Preview image</strong>.',
    'KJ_META_SEO_HELP_STEP_5' => 'Click <strong>Update Settings</strong>.',
    'KJ_META_SEO_HELP_STEP_6' =>
        'Open your home page, view its source, and find the tags between <code>kj_meta_seo start</code> and <code>kj_meta_seo end</code>.',

    //
    // common questions
    //
    'KJ_META_SEO_HELP_FAQ_Q_1' => 'Why does a shared link still show the old title or image?',
    'KJ_META_SEO_HELP_FAQ_A_1' =>
        'Social networks keep the preview of a link for a while. Paste the link in the <a href="https://developers.facebook.com/tools/debug/" target="_blank" rel="noopener">Facebook Sharing Debugger</a> and click <strong>Scrape Again</strong> to refresh it there. The other apps refresh their previews on their own later.',
    'KJ_META_SEO_HELP_FAQ_Q_2' => 'Which image works best?',
    'KJ_META_SEO_HELP_FAQ_A_2' =>
        'A square PNG or JPEG image, at least 300 × 300 pixels and smaller than 5 MB. X shows it as a square beside the title, so keep the important part in the middle.',
    'KJ_META_SEO_HELP_FAQ_Q_3' => 'Do the keywords help my ranking?',
    'KJ_META_SEO_HELP_FAQ_A_3' =>
        'Very little. Google ignores the keywords tag, and the other search engines give it little weight. The description matters more: search engines often show it under your page in their results, so write it for people.',
    'KJ_META_SEO_HELP_FAQ_Q_4' => 'Where does the description of a download page come from?',
    'KJ_META_SEO_HELP_FAQ_A_4' =>
        'From the title of the page, which is the file name followed by <strong>Download</strong>. Kleeja shortens long file names in the title, and the description is shortened with them.',
    'KJ_META_SEO_HELP_FAQ_Q_5' => 'Does the plugin change my style?',
    'KJ_META_SEO_HELP_FAQ_A_5' =>
        'No. It only adds tags to the head of the pages, which visitors don\'t see. If your style has its own description tag, remove it from the <code>header.html</code> of the style, so pages don\'t have two.',

    //
    // beside the guide
    //
    'KJ_META_SEO_HELP_TIP_1' =>
        'Write the home page description as one or two sentences about your site, like what visitors can upload and how long files are kept, rather than a list of words.',
    'KJ_META_SEO_HELP_TIP_2' =>
        'The preview image is the same on every page. Use your logo or a picture of your site, not an image that belongs to one page.',

    'KJ_META_SEO_HELP_WARNING_1' =>
        'Social networks read the tags from your server, so links to a site that the internet can\'t reach, like <code>localhost</code>, show no preview.',
    'KJ_META_SEO_HELP_WARNING_2' =>
        'Deleting the plugin deletes its settings, the home page description and keywords too. Copy them first if you will need them again.',

    //
    // in the guide of the settings, whose page has the tab of the plugin
    //
    'KJ_META_SEO_HELP_NOTE' =>
        'The <strong>Meta SEO settings</strong> tab belongs to the <strong>Meta SEO</strong> plugin. <a href="#help-kj_meta_seo">Read its guide</a>.',
];
