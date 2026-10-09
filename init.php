<?php
// Kleeja Plugin
// kj_meta_seo
// Version: 1.2.0
// Developer: Kleeja team

// Prevent illegal run
if (!defined('IN_PLUGINS_SYSTEM')) {
    exit();
}

// Plugin Basic Information
$kleeja_plugin['kj_meta_seo']['information'] = [
    // The casual name of this plugin, anything can a human being understands
    'plugin_title' => [
        'en' => 'Meta SEO',
        'ar' => 'وسوم الميتا لمحركات البحث',
    ],
    // Who wrote this plugin?
    'plugin_developer' => 'Kleeja.net',
    //settings page, if there is one (what after ? like cp=j_plugins)
    'settings_page' => 'cp=options&smt=kj_meta_seo',
    // This plugin version
    'plugin_version' => '1.2.0',
    // Explain what is this plugin, why should I use it?
    'plugin_description' => [
        'en' =>
            'Add a description, keywords, Open Graph and X (Twitter) Card tags to the pages of your site, for search engines and for the previews of shared links.',
        'ar' =>
            'تضيف إلى صفحات موقعك وصفًا وكلمات مفتاحية ووسوم Open Graph وبطاقات X (تويتر)، لمحركات البحث ولمعاينة الروابط المشاركة.',
    ],
    // Min version of Kleeja that's requiered to run this plugin
    'plugin_kleeja_version_min' => '4.0.0',
    // Max version of Kleeja that support this plugin, use 0 for unlimited
    'plugin_kleeja_version_max' => '4.9',
    // Should this plugin run before others?, 0 is normal, and higher number has high priority
    'plugin_priority' => 0,
];

//after installation message, you can remove it, it's not requiered
$kleeja_plugin['kj_meta_seo']['first_run']['ar'] = "
تضيف هذه الإضافة إلى صفحات موقعك وصفًا وكلمات مفتاحية لمحركات البحث، ووسوم Open Graph وبطاقات X (تويتر)
التي تعرض عنوانًا ووصفًا وصورة عند مشاركة رابط من موقعك. تجد خياراتها في تبويب «خيارات وسوم الميتا» من صفحة الإعدادات.
<br>
<a href='./index.php?cp=options&amp;smt=kj_meta_seo'>خيارات وسوم الميتا</a> -
<a href='https://github.com/kleeja/kj_meta_seo/issues' target='_blank' rel='noopener'>الإبلاغ عن مشكلة</a>
";

$kleeja_plugin['kj_meta_seo']['first_run']['en'] = "
This plugin adds a description and keywords for search engines to the pages of your site, with Open Graph
and X (Twitter) Card tags that show a title, a description and an image when a link to your site is shared.
Its options are in the Meta SEO settings tab of the Settings page.
<br>
<a href='./index.php?cp=options&amp;smt=kj_meta_seo'>Meta SEO settings</a> -
<a href='https://github.com/kleeja/kj_meta_seo/issues' target='_blank' rel='noopener'>Report a problem</a>
";

// Plugin Installation function
$kleeja_plugin['kj_meta_seo']['install'] = function ($plg_id) {
    $options = [];

    foreach (kj_meta_seo_configs() as $name => $setting) {
        $options[$name] = [
            'value' => $setting['value'],
            'html' => $setting['html'],
            'order' => $setting['order'],
            'plg_id' => $plg_id,
            'type' => 'kj_meta_seo',
        ];
    }

    add_config_r($options);

    foreach (kj_meta_seo_translations() as $lang_id => $words) {
        add_olang($words, $lang_id, $plg_id);
    }
};

// the words and the fields of the settings are written again, so a new version brings its own (1.2.0 rewrote all of them),
// with queries of its own: add_olang(), delete_olang(), update_config() and delete_cache() run hooks,
// or need the groups, and the plugins are still loading.
// $kleeja_plugin isn't a global, Kleeja includes this file in a method, so the closure takes the information above with it
$kleeja_plugin['kj_meta_seo']['update'] = function ($old_version, $new_version) use ($kleeja_plugin) {
    global $SQL, $dbprefix;

    $result = $SQL->build([
        'SELECT' => 'plg_id',
        'FROM' => "{$dbprefix}plugins",
        'WHERE' => 'plg_name = :name',
        'BIND' => ['name' => 'kj_meta_seo'],
    ]);

    $row = $SQL->fetch_array($result);
    $plg_id = (int) ($row['plg_id'] ?? 0);
    $SQL->freeresult($result);

    //a plg_id of 0 would delete the words of the core and of every plugin
    if ($plg_id > 0) {
        $SQL->build([
            'DELETE' => "{$dbprefix}lang",
            'WHERE' => 'plg_id = :plg_id',
            'BIND' => ['plg_id' => $plg_id],
        ]);

        foreach (kj_meta_seo_translations() as $lang_id => $words) {
            foreach ($words as $word => $trans) {
                $SQL->build([
                    'INSERT' => 'word, trans, lang_id, plg_id',
                    'INTO' => "{$dbprefix}lang",
                    'VALUES' => ':word, :trans, :lang_id, :plg_id',
                    'BIND' => ['word' => $word, 'trans' => $trans, 'lang_id' => $lang_id, 'plg_id' => $plg_id],
                ]);
            }
        }
    }

    // the fields of the settings page, and their order, the values are kept
    foreach (kj_meta_seo_configs() as $name => $setting) {
        $SQL->build([
            'UPDATE' => "{$dbprefix}config",
            'SET' => '`option` = :option, display_order = :display_order',
            'WHERE' => 'name = :name',
            'BIND' => ['option' => $setting['html'], 'display_order' => $setting['order'], 'name' => $name],
        ]);
    }

    // the developer and the description that versions before 1.2.0 were installed with,
    // the list of plugins shows them while the plugin is disabled
    if (version_compare($old_version, '1.2.0', '<')) {
        $SQL->build([
            'UPDATE' => "{$dbprefix}plugins",
            'SET' => 'plg_author = :author, plg_dsc = :description',
            'WHERE' => 'plg_name = :name',
            'BIND' => [
                'author' => 'Kleeja.net',
                'description' => kleeja_html_encode(
                    $kleeja_plugin['kj_meta_seo']['information']['plugin_description']['en'],
                ),
                'name' => 'kj_meta_seo',
            ],
        ]);
    }

    // the cached words and settings
    $cached = array_merge(glob(PATH . 'cache/data_lang*.php') ?: [], glob(PATH . 'cache/data_config.php') ?: []);

    foreach ($cached as $file) {
        if (file_exists($file)) {
            @unlink($file);
        }
    }
};

// Plugin Uninstallation, function to be called at unistalling
$kleeja_plugin['kj_meta_seo']['uninstall'] = function ($plg_id) {
    delete_config(array_keys(kj_meta_seo_configs()));

    //a plg_id of 0 would delete the words of the core and of every plugin
    if ((int) $plg_id > 0) {
        foreach (array_keys(kj_meta_seo_translations()) as $lang_id) {
            delete_olang(null, $lang_id, (int) $plg_id);
        }
    }
};

// Plugin functions
$kleeja_plugin['kj_meta_seo']['functions'] = [
    //the words of the plugin on the settings page, in English for a language that has no translation of them
    'begin_admin_page' => function ($args) {
        $olang = (array) ($args['olang'] ?? []) + kj_meta_seo_translations()['en'];

        return compact('olang');
    },

    //the tags of the page, in the head that Saaheader() prints, its title is the one of the page
    'Saaheader_links_func' => function ($args) {
        $page = defined('IN_DOWNLOAD') ? 'download' : (defined('IN_REAL_INDEX') ? 'home' : 'any');
        $extra = $args['extra'] . kj_meta_seo_out($page, (string) ($args['title'] ?? ''));

        return compact('extra');
    },

    // the guide of the plugin on the help page of the control panel, its words are in language/help_{code}.php
    'admin_help_guides' => function ($args) {
        $help_guides = $args['help_guides'];
        $words = kj_meta_seo_help_words();

        // the name of the plugin is the key, so Kleeja knows that the plugin has its guide, and shows its icon.
        // The options of the plugin are a tab of the settings page, whose help button opens the guide of Kleeja,
        // so it has no 'page', and the guide of the settings links to it
        $help_guides['kj_meta_seo'] = [
            'group' => 'plugins',
            'title' => $words['KJ_META_SEO_HELP_TITLE'],
            'intro' => $words['KJ_META_SEO_HELP_INTRO'],
            'link' => './?cp=options&amp;smt=kj_meta_seo',
            // tips and warnings are shown beside the others on wide screens
            'sections' => [
                kj_meta_seo_help_section($words, 'features', 'FEATURE'),
                kj_meta_seo_help_section($words, 'steps', 'STEP'),
                kj_meta_seo_help_section($words, 'faq', 'FAQ'),
                kj_meta_seo_help_section($words, 'tips', 'TIP'),
                kj_meta_seo_help_section($words, 'warnings', 'WARNING'),
            ],
        ];

        if (isset($help_guides['settings'])) {
            $help_guides['settings']['sections'][] = ['type' => 'text', 'text' => $words['KJ_META_SEO_HELP_NOTE']];
        }

        return compact('help_guides');
    },
];

/**
 * special functions
 */

if (!function_exists('kj_meta_seo_configs')) {
    /**
     * the settings of the plugin, with the values that it is installed with, their order,
     * and their fields on the settings page, which adds the classes of Bootstrap to them
     * @return array
     */
    function kj_meta_seo_configs()
    {
        $yes_no = function ($name) {
            $html = '';

            foreach (['1' => 'YES', '0' => 'NO'] as $value => $word) {
                $html .=
                    '<label>{lang.' .
                    $word .
                    '}<input type="radio" id="' .
                    $name .
                    ($value ? '' : '_no') .
                    '" name="' .
                    $name .
                    '" value="' .
                    $value .
                    '"<IF NAME="con.' .
                    $name .
                    '==' .
                    $value .
                    '"> checked="checked"</IF> /></label>';
            }

            return $html;
        };

        $text = function ($name, $attributes = '') {
            return '<input type="text" id="' .
                $name .
                '" name="' .
                $name .
                '" value="{con.' .
                $name .
                '}"' .
                $attributes .
                ' />';
        };

        return [
            'kj_meta_seo_home_meta_description' => [
                'value' => '',
                'order' => 1,
                'html' => $text('kj_meta_seo_home_meta_description', ' maxlength="255"'),
            ],
            'kj_meta_seo_home_meta_keywords' => [
                'value' => '',
                'order' => 2,
                'html' => $text('kj_meta_seo_home_meta_keywords', ' maxlength="255"'),
            ],
            'kj_meta_seo_enable_auto_meta' => [
                'value' => '1',
                'order' => 3,
                'html' => $yes_no('kj_meta_seo_enable_auto_meta'),
            ],
            'kj_meta_seo_enable_download_auto_meta' => [
                'value' => '1',
                'order' => 4,
                'html' => $yes_no('kj_meta_seo_enable_download_auto_meta'),
            ],
            'kj_meta_seo_enable_facebook_meta_tags' => [
                'value' => '1',
                'order' => 5,
                'html' => $yes_no('kj_meta_seo_enable_facebook_meta_tags'),
            ],
            'kj_meta_seo_enable_twitter_meta_tags' => [
                'value' => '1',
                'order' => 6,
                'html' => $yes_no('kj_meta_seo_enable_twitter_meta_tags'),
            ],
            // a file name is written from left to right
            'kj_meta_seo_image_path' => [
                'value' => 'iPhone.png',
                'order' => 7,
                'html' => $text('kj_meta_seo_image_path', ' dir="ltr" autocomplete="off" spellcheck="false"'),
            ],
        ];
    }

    /**
     * the meta tags of a page
     * @param  string $page  home, download, or any for the other pages
     * @param  string $title the title of the page, as Saaheader() got it
     * @return string
     */
    function kj_meta_seo_out($page, $title)
    {
        global $config, $file_info;

        if ($page == 'download' && empty($config['kj_meta_seo_enable_download_auto_meta'])) {
            return '';
        }

        if ($page == 'any' && empty($config['kj_meta_seo_enable_auto_meta'])) {
            return '';
        }

        $site_name = kj_meta_seo_text($config['sitename'] ?? '');
        $title = kj_meta_seo_text($title);

        switch ($page) {
            case 'home':
                // the home page has no title of its own
                $title = $title === '' ? $site_name : $title;
                $description = kj_meta_seo_text($config['kj_meta_seo_home_meta_description'] ?? '');
                $keywords = kj_meta_seo_text(str_replace('،', ',', $config['kj_meta_seo_home_meta_keywords'] ?? ''));
                $keywords = implode(', ', array_unique(array_filter(array_map('trim', explode(',', $keywords)))));

                break;

            case 'download':
                // a plugin that gives files a description adds it to $file_info
                $title = $title === '' ? $site_name : $title;
                $description = kj_meta_seo_text($file_info['about'] ?? '');
                $description = $description === '' ? $title : $description;
                $keywords = kj_meta_seo_keywords($title);

                break;

            default:
                $title = $title === '' ? $site_name : $title;
                $description = $title;
                $keywords = kj_meta_seo_keywords($title);

                break;
        }

        $image = trim(kj_meta_seo_text($config['kj_meta_seo_image_path'] ?? ''), '/ ');
        $image =
            $image === ''
                ? ''
                : rtrim($config['siteurl'], '/') .
                    '/images/' .
                    implode('/', array_map('rawurlencode', explode('/', $image)));

        $tags = [['name', 'description', $description], ['name', 'keywords', $keywords]];

        if (!empty($config['kj_meta_seo_enable_facebook_meta_tags'])) {
            array_push(
                $tags,
                ['property', 'og:type', 'website'],
                ['property', 'og:title', $title],
                ['property', 'og:image', $image],
                ['property', 'og:url', kj_meta_seo_current_url()],
                ['property', 'og:site_name', $site_name],
                ['property', 'og:description', $description],
            );
        }

        if (!empty($config['kj_meta_seo_enable_twitter_meta_tags'])) {
            array_push(
                $tags,
                ['name', 'twitter:card', 'summary'],
                ['name', 'twitter:title', $title],
                ['name', 'twitter:description', $description],
                ['name', 'twitter:image', $image],
            );
        }

        $metas = [];

        //a tag without a value says nothing, like the description of a home page that has none yet
        foreach ($tags as [$attribute, $name, $content]) {
            if ($content !== '') {
                $metas[] =
                    '<meta ' .
                    $attribute .
                    '="' .
                    $name .
                    '" content="' .
                    htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') .
                    '">';
            }
        }

        return "\n    <!-- kj_meta_seo start -->\n    " .
            implode("\n    ", $metas) .
            "\n    <!-- kj_meta_seo end -->\n";
    }

    /**
     * a text of Kleeja as plain text in one line, to be encoded once in a tag
     * @param  string $text
     * @return string
     */
    function kj_meta_seo_text($text)
    {
        $text = (string) $text;

        // Kleeja keeps its texts encoded for HTML, and its settings page encoded them once more at every save
        // before 4.0.0, so an old text can have a few layers; a decoded text is shorter, so this ends
        while (str_contains($text, '&')) {
            $decoded = htmlspecialchars_decode($text, ENT_QUOTES);

            if ($decoded === $text) {
                break;
            }

            $text = $decoded;
        }

        // a letter that isn't valid UTF-8, like in a file name sent in another charset, is dropped,
        // or the patterns below would fail on the whole text
        $text = str_replace(
            "\u{FFFD}",
            '',
            htmlspecialchars_decode(htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'), ENT_QUOTES),
        );

        return trim(preg_replace('/\s+/u', ' ', $text));
    }

    /**
     * the words of a title as keywords, in any language
     * @param  string $text plain text
     * @return string
     */
    function kj_meta_seo_keywords($text)
    {
        $words = preg_split('/[^\p{L}\p{M}\p{N}_]+/u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        // two letters at least, mbstring is optional in Kleeja
        return implode(', ', array_unique(array_filter($words, fn($word) => preg_match('/^.{2}/su', $word))));
    }

    /**
     * the address of the page, on the host and with the scheme of the address of the site,
     * the Host header of the request is not trusted
     * @return string
     */
    function kj_meta_seo_current_url()
    {
        global $config;

        $site = parse_url($config['siteurl']);

        if (empty($site['host'])) {
            return '';
        }

        return ($site['scheme'] ?? 'http') .
            '://' .
            $site['host'] .
            (isset($site['port']) ? ':' . $site['port'] : '') .
            '/' .
            ltrim((string) ($_SERVER['REQUEST_URI'] ?? ''), '/');
    }

    /**
     * the words of the guide on the help page, in the language of the admin,
     * a word that the translation misses is shown in English
     * @return array
     */
    function kj_meta_seo_help_words()
    {
        global $config;

        $words = (array) require __DIR__ . '/language/help_en.php';
        $language = preg_replace('/[^a-z0-9_-]/i', '', (string) ($config['language'] ?? ''));
        $translation = __DIR__ . "/language/help_{$language}.php";

        if ($language !== '' && $language !== 'en' && file_exists($translation)) {
            // in its own line, Prettier drops the brackets of (require $translation) + $words
            $translated = require $translation;
            $words = (array) $translated + $words;
        }

        return $words;
    }

    /**
     * a section of the guide from its numbered words, like KJ_META_SEO_HELP_TIP_1, KJ_META_SEO_HELP_TIP_2 ..
     * its title, when it has its own, is KJ_META_SEO_HELP_TIP_TITLE
     * @param  array  $words
     * @param  string $type  how Kleeja shows it: features, steps, tips, warnings or faq
     * @param  string $name  the name of its words, KJ_META_SEO_HELP_{name}_1
     * @return array
     */
    function kj_meta_seo_help_section($words, $type, $name)
    {
        $prefix = 'KJ_META_SEO_HELP_' . $name;
        $section = ['type' => $type, 'title' => $words[$prefix . '_TITLE'] ?? '', 'items' => []];

        for ($n = 1; isset($words[$prefix . ($type == 'faq' ? '_Q_' : '_') . $n]); $n++) {
            $section['items'][] =
                $type == 'faq'
                    ? ['q' => $words[$prefix . '_Q_' . $n], 'a' => $words[$prefix . '_A_' . $n] ?? '']
                    : $words[$prefix . '_' . $n];
        }

        return $section;
    }

    /**
     * the words of the plugin, they are added to the language table when it is installed or updated,
     * a <small> in the name of a setting is the hint under it
     * @return array
     */
    function kj_meta_seo_translations()
    {
        return [
            'en' => [
                'CONFIG_KLJ_MENUS_KJ_META_SEO' => 'Meta SEO settings',
                'KJ_META_SEO_HOME_META_DESCRIPTION' =>
                    'Home page description <small>A short summary of your site. Search engines show it under the name of your site in their results, and social networks show it when a link to the home page is shared. Around 160 characters at most.</small>',
                'KJ_META_SEO_HOME_META_KEYWORDS' =>
                    'Home page keywords <small>Words that describe your site, separated by commas, like <span class="text-nowrap">file upload, file sharing</span>.</small>',
                'KJ_META_SEO_ENABLE_AUTO_META' =>
                    'Generate tags for the other pages <small>Builds the description and the keywords of every other page, like the Terms or the Contact Us page, from its title. When disabled, these pages get no tags from this plugin.</small>',
                'KJ_META_SEO_ENABLE_DOWNLOAD_AUTO_META' =>
                    'Generate tags for download pages <small>Builds the description and the keywords of every download page from the file name. When disabled, download pages get no tags from this plugin.</small>',
                'KJ_META_SEO_ENABLE_FACEBOOK_META_TAGS' =>
                    'Add Open Graph tags <small>Lets Facebook, WhatsApp, LinkedIn and other apps show a title, a description and an image when a link to your site is shared.</small>',
                'KJ_META_SEO_ENABLE_TWITTER_META_TAGS' =>
                    'Add X (Twitter) Card tags <small>Lets X show a card with a title, a description and an image when a link to your site is shared.</small>',
                'KJ_META_SEO_IMAGE_PATH' =>
                    'Preview image <small>The name of an image in the images folder of Kleeja, like <span class="text-nowrap">iPhone.png</span>, shown in the previews of shared links. Leave it empty to share links without an image.</small>',
            ],
            'ar' => [
                'CONFIG_KLJ_MENUS_KJ_META_SEO' => 'خيارات وسوم الميتا',
                'KJ_META_SEO_HOME_META_DESCRIPTION' =>
                    'وصف الصفحة الرئيسية <small>ملخص قصير لموقعك، تعرضه محركات البحث تحت اسم موقعك في نتائجها، وتعرضه الشبكات الاجتماعية عند مشاركة رابط الصفحة الرئيسية. يُفضَّل ألا يتجاوز 160 حرفًا تقريبًا.</small>',
                'KJ_META_SEO_HOME_META_KEYWORDS' =>
                    'الكلمات المفتاحية للصفحة الرئيسية <small>كلمات تصف موقعك، تفصل بينها فواصل، مثل: <span class="text-nowrap">رفع الملفات، مشاركة الملفات</span>.</small>',
                'KJ_META_SEO_ENABLE_AUTO_META' =>
                    'إنشاء الوسوم لبقية الصفحات <small>يُنشئ وصف كل صفحة أخرى وكلماتها المفتاحية من عنوانها، مثل صفحة شروط الخدمة أو صفحة اتصل بنا. عند تعطيله لا تضيف الإضافة أي وسوم إلى هذه الصفحات.</small>',
                'KJ_META_SEO_ENABLE_DOWNLOAD_AUTO_META' =>
                    'إنشاء الوسوم لصفحات التحميل <small>يُنشئ وصف كل صفحة تحميل وكلماتها المفتاحية من اسم الملف. عند تعطيله لا تضيف الإضافة أي وسوم إلى صفحات التحميل.</small>',
                'KJ_META_SEO_ENABLE_FACEBOOK_META_TAGS' =>
                    'إضافة وسوم Open Graph <small>تتيح لفيسبوك وواتساب ولينكدإن وغيرها عرض عنوان ووصف وصورة عند مشاركة رابط من موقعك.</small>',
                'KJ_META_SEO_ENABLE_TWITTER_META_TAGS' =>
                    'إضافة وسوم بطاقات X (تويتر) <small>تتيح لمنصة X عرض بطاقة فيها عنوان ووصف وصورة عند مشاركة رابط من موقعك.</small>',
                'KJ_META_SEO_IMAGE_PATH' =>
                    'صورة المعاينة <small>اسم صورة في مجلد images في كليجا، مثل <span dir="ltr" class="text-nowrap">iPhone.png</span>، تظهر في معاينة الروابط المشاركة. اتركه فارغًا لمشاركة الروابط دون صورة.</small>',
            ],
        ];
    }
}
