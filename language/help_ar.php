<?php
//
// kj_meta_seo, its guide on the help page of the control panel
// Arabic
//
// The guide is built by the admin_help_guides hook in init.php, the texts here can have HTML.
// The keys are the ones of help_en.php, a key that is missing here is shown in English.
//  - names in <strong> are written as the control panel shows them: the words of Kleeja are in lang/ar/,
//    the words of the plugin in kj_meta_seo_translations() of init.php
//  - a <code> that begins or ends with a symbol has dir="ltr", or the symbol moves to the other side
//

return [
    'KJ_META_SEO_HELP_TITLE' => 'وسوم الميتا لمحركات البحث',
    'KJ_META_SEO_HELP_INTRO' =>
        'عرّف محركات البحث والشبكات الاجتماعية بموقعك. تضيف الإضافة وصفًا وكلمات مفتاحية إلى ترويسة كل صفحة، مع وسوم Open Graph وبطاقات X (تويتر) التي تمنح الروابط المشاركة عنوانًا ووصفًا وصورة.',

    //
    // what the plugin does
    //
    'KJ_META_SEO_HELP_FEATURE_1' => 'تحصل الصفحة الرئيسية على الوصف والكلمات المفتاحية التي تكتبها.',
    'KJ_META_SEO_HELP_FEATURE_2' =>
        'تأخذ صفحات التحميل وصفها وكلماتها المفتاحية من اسم الملف، وتأخذها بقية الصفحات، مثل <strong>شروط الخدمة</strong> أو <strong>اتصل بنا</strong>، من عنوانها.',
    'KJ_META_SEO_HELP_FEATURE_3' =>
        'وسوم Open Graph (<code>og:title</code> و<code>og:description</code> و<code>og:image</code> و<code>og:url</code> و<code>og:site_name</code>) لفيسبوك وواتساب ولينكدإن وتيليجرام وغيرها من التطبيقات التي تعرض معاينة للروابط.',
    'KJ_META_SEO_HELP_FEATURE_4' =>
        'وسوم بطاقات X (تويتر) من نوع <code>summary</code>: بطاقة صغيرة فيها صورة المعاينة بجانب العنوان والوصف.',
    'KJ_META_SEO_HELP_FEATURE_5' => 'تُبنى الكلمات المفتاحية من كلمات العنوان بأي لغة، والعربية منها.',

    //
    // how to use it
    //
    'KJ_META_SEO_HELP_STEP_TITLE' => 'إعداد الوسوم',
    'KJ_META_SEO_HELP_STEP_1' => 'افتح <strong>إعدادات</strong>، ثم <strong>خيارات وسوم الميتا</strong>.',
    'KJ_META_SEO_HELP_STEP_2' =>
        'اكتب <strong>وصف الصفحة الرئيسية</strong> و<strong>الكلمات المفتاحية للصفحة الرئيسية</strong>.',
    'KJ_META_SEO_HELP_STEP_3' =>
        'اختر الصفحات والوسوم التي تريدها عبر <strong>إنشاء الوسوم لبقية الصفحات</strong> و<strong>إنشاء الوسوم لصفحات التحميل</strong> و<strong>إضافة وسوم Open Graph</strong> و<strong>إضافة وسوم بطاقات X (تويتر)</strong>.',
    'KJ_META_SEO_HELP_STEP_4' =>
        'ضع صورة المعاينة في مجلد <code>images</code> في كليجا، واكتب اسم ملفها في <strong>صورة المعاينة</strong>.',
    'KJ_META_SEO_HELP_STEP_5' => 'اضغط <strong>تحديث الإعدادات</strong>.',
    'KJ_META_SEO_HELP_STEP_6' =>
        'افتح صفحتك الرئيسية، واعرض مصدرها، وابحث عن الوسوم بين <code dir="ltr">kj_meta_seo start</code> و<code dir="ltr">kj_meta_seo end</code>.',

    //
    // common questions
    //
    'KJ_META_SEO_HELP_FAQ_Q_1' => 'لماذا يظهر الرابط المشارك بالعنوان أو الصورة القديمة؟',
    'KJ_META_SEO_HELP_FAQ_A_1' =>
        'تحتفظ الشبكات الاجتماعية بمعاينة الرابط بعض الوقت. الصق الرابط في <a href="https://developers.facebook.com/tools/debug/" target="_blank" rel="noopener">أداة تصحيح المشاركة في فيسبوك</a> واضغط <strong>Scrape Again</strong> لتحديثها هناك، أما بقية التطبيقات فتحدّث معايناتها من تلقاء نفسها لاحقًا.',
    'KJ_META_SEO_HELP_FAQ_Q_2' => 'ما الصورة الأنسب للمعاينة؟',
    'KJ_META_SEO_HELP_FAQ_A_2' =>
        'صورة مربعة بصيغة PNG أو JPEG، لا تقل عن 300 × 300 بكسل، وحجمها أقل من 5 ميجابايت. تعرضها X مربعةً بجانب العنوان، لذا اجعل الجزء المهم منها في المنتصف.',
    'KJ_META_SEO_HELP_FAQ_Q_3' => 'هل تحسّن الكلمات المفتاحية ترتيب موقعي؟',
    'KJ_META_SEO_HELP_FAQ_A_3' =>
        'تأثيرها ضئيل. تتجاهل Google وسم الكلمات المفتاحية، ولا تمنحه محركات البحث الأخرى وزنًا يُذكر. الوصف أهم منه، فمحركات البحث تعرضه غالبًا تحت صفحتك في نتائجها، لذا اكتبه للقرّاء.',
    'KJ_META_SEO_HELP_FAQ_Q_4' => 'من أين يأتي وصف صفحة التحميل؟',
    'KJ_META_SEO_HELP_FAQ_A_4' =>
        'من عنوان الصفحة، وهو اسم الملف متبوعًا بكلمة <strong>تحميل</strong>. تختصر كليجا أسماء الملفات الطويلة في العنوان، فيُختصر الوصف معها.',
    'KJ_META_SEO_HELP_FAQ_Q_5' => 'هل تغيّر الإضافة ستايل موقعي؟',
    'KJ_META_SEO_HELP_FAQ_A_5' =>
        'لا. تضيف الإضافة وسومًا إلى ترويسة الصفحات فقط، ولا يراها الزوار. وإن كان في ستايلك وسم وصف خاص به، فاحذفه من ملف <code>header.html</code> في الستايل، حتى لا يتكرر الوصف في الصفحة.',

    //
    // beside the guide
    //
    'KJ_META_SEO_HELP_TIP_1' =>
        'اكتب وصف الصفحة الرئيسية في جملة أو جملتين عن موقعك، مثل ما يمكن للزوار رفعه ومدة الاحتفاظ بالملفات، بدلًا من سرد الكلمات.',
    'KJ_META_SEO_HELP_TIP_2' =>
        'صورة المعاينة واحدة في كل الصفحات، فاستخدم شعارك أو صورة تمثّل موقعك، لا صورة تخص صفحة بعينها.',

    'KJ_META_SEO_HELP_WARNING_1' =>
        'تقرأ الشبكات الاجتماعية الوسوم من خادمك، لذا لا تظهر معاينة لروابط موقع لا يمكن الوصول إليه من الإنترنت، مثل <code>localhost</code>.',
    'KJ_META_SEO_HELP_WARNING_2' =>
        'حذف الإضافة يحذف إعداداتها، ومنها وصف الصفحة الرئيسية وكلماتها المفتاحية. انسخها قبل الحذف إن كنت ستحتاج إليها لاحقًا.',

    //
    // in the guide of the settings, whose page has the tab of the plugin
    //
    'KJ_META_SEO_HELP_NOTE' =>
        'تبويب <strong>خيارات وسوم الميتا</strong> تابع لإضافة <strong>وسوم الميتا لمحركات البحث</strong>. <a href="#help-kj_meta_seo">اقرأ دليلها</a>.',
];
