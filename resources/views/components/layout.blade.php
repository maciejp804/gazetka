<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gazetka Promocyjna</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-blue-200">

<header class="w-full">
    <div class="max-w-[1420px] m-auto flex flex-row">
        <div>
            <div>
                <div>
                    <div class="flex">
                        <div>
                            <a href="/">
                                <img src="https://hoian.pl/assets/image/Logo.png" alt="logo-image">
                            </a>
                        </div>
                        <div id="navbarContent">
                            <div>
                                <div>
                                    <ul class="flex space-x-6">
                                        <li>
                                            <a href="#">
                                                <span>Gazetki promocyjne</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span>Sieci handlowe</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span>Abc zakupowicza</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span>Kupony</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex">
                            <input type="text" name="search" placeholder="Szukaj produktów w gazetkach">
                            <a href="#" >
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                        <div>
                            <ul class="flex">
                                <li class="side-wrap wishlist-wrap mob-only">
                                    <a href="#" class="header-wishlist background_imgs">
                                        <img src="https://hoian.pl/assets/image/pro/Vector (1).png" class="background_imgs_margin img_z7a3fm">
                                    </a>
                                </li>
                                <li class="side-wrap nav-toggler mob-only-toggle toggle_btn">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
                                        <span class="line"></span>
                                    </button>
                                </li>
                                <li class="side-wrap wishlist-wrap desktop-only">
                                    <a href="javascript:select_location()" class="header-wishlist background_imgs">
                                        <img src="https://hoian.pl/assets/image/pro/Vector (1).png" class="background_imgs_margin">
                                    </a>
                                </li>
                                <li class="side-wrap wishlist-wrap desktop-only">
                                    <a href="/dashboard/" class="header-wishlist background_imgs">
                                        <img src="https://hoian.pl/assets/image/pro/Vector (2).png" class="background_imgs_margin">
                                    </a>
                                </li>
                                <li class="side-wrap wishlist-wrap desktop-only">
                                    <a href="/dashboard/" class="header-wishlist background_imgs">
                                        <img src="https://hoian.pl/assets/image/pro/Group.png" class="background_imgs_margin">
                                    </a>
                                </li>
                                <li class="side-wrap wishlist-wrap desktop-only">
                                    <a onclick="toggleTheme()" class="header-wishlist background_imgs">
                                        <img src="https://hoian.pl/assets/image/pro/brightness 1.png" class="background_imgs_margin">
                                    </a>
                                </li>
                                <li class="side-wrap wishlist-wrap desktop-only">
                                    <a href="javascript:void(0)" class="header-wishlist background_imgs a_gnbte7" onclick="toggleLang()">PL</a>
                                    <div class="lang-box notranslate" id="lang-box">
                                        <div class="item" onclick="select_lang('en')">English</div>
                                        <div class="item" onclick="select_lang('cn')">Chinese</div>
                                        <div class="item" onclick="select_lang('pl')">Polish</div>
                                        <div class="item" onclick="select_lang('ja')">Japanese</div>
                                        <div class="item" onclick="select_lang('ru')">Russian</div>
                                        <div class="item" onclick="select_lang('ko')">Korean</div>
                                    </div>
                                    <div id="google_translate_element"><div class="skiptranslate goog-te-gadget" dir="ltr" style=""><div id=":0.targetLanguage"><select class="goog-te-combo" aria-label="Widżet języka Tłumacza"><option value="">Wybierz język</option><option value="ab">abchaski</option><option value="ace">aceh</option><option value="ach">aczoli</option><option value="aa">afar</option><option value="af">afrikaans</option><option value="ay">ajmara</option><option value="sq">albański</option><option value="alz">alur</option><option value="am">amharski</option><option value="en">angielski</option><option value="ar">arabski</option><option value="as">asamski</option><option value="awa">awadhi</option><option value="av">awarski</option><option value="az">azerski</option><option value="ban">balijski</option><option value="bm">bambara</option><option value="eu">baskijski</option><option value="ba">baszkirski</option><option value="btx">batak karo</option><option value="bts">batak simalungun</option><option value="bbc">batak toba</option><option value="bci">baule</option><option value="bal">beludżi</option><option value="bem">bemba</option><option value="bn">bengalski</option><option value="bew">betawi</option><option value="bho">bhodźpuri</option><option value="be">białoruski</option><option value="bik">bikolski</option><option value="my">birmański</option><option value="bs">bośniacki</option><option value="br">bretoński</option><option value="bg">bułgarski</option><option value="bua">buriacki</option><option value="ceb">cebuański</option><option value="cgg">chiga</option><option value="zh-TW">chiński (tradycyjny)</option><option value="zh-CN">chiński (uproszczony)</option><option value="hr">chorwacki</option><option value="chk">chuuk</option><option value="ch">czamorro</option><option value="ce">czeczeński</option><option value="cs">czeski</option><option value="ny">cziczewa</option><option value="cv">czuwaski</option><option value="fa-AF">dari</option><option value="dv">dhivehi</option><option value="din">dinka</option><option value="dyu">diula</option><option value="doi">dogri</option><option value="dov">dombe</option><option value="da">duński</option><option value="dz">dzongkha</option><option value="eo">esperanto</option><option value="et">estoński</option><option value="ee">ewe</option><option value="fo">farerski</option><option value="fj">fidżyjski</option><option value="tl">filipiński</option><option value="fi">fiński</option><option value="fon">fon</option><option value="fr">francuski</option><option value="fur">friulski</option><option value="fy">fryzyjski</option><option value="ff">ful</option><option value="gaa">ga</option><option value="gl">galicyjski</option><option value="el">grecki</option><option value="kl">grenlandzki</option><option value="ka">gruziński</option><option value="gn">guarani</option><option value="gu">gudżarati</option><option value="ha">hausa</option><option value="haw">hawajski</option><option value="iw">hebrajski</option><option value="hil">hiligaynon</option><option value="hi">hindi</option><option value="es">hiszpański</option><option value="hmn">hmong</option><option value="hrx">hunsrik</option><option value="iba">iban</option><option value="ig">igbo</option><option value="ilo">ilokański</option><option value="id">indonezyjski</option><option value="ga">irlandzki</option><option value="is">islandzki</option><option value="sah">jakucki</option><option value="jam">jamajski</option><option value="ja">japoński</option><option value="jw">jawajski</option><option value="yi">jidysz</option><option value="kac">jingpo</option><option value="yo">joruba</option><option value="kn">kannada</option><option value="yue">kantoński</option><option value="kr">kanuri</option><option value="ca">kataloński</option><option value="kk">kazachski</option><option value="qu">keczua</option><option value="kek">kekczi</option><option value="kha">khasi</option><option value="km">khmerski</option><option value="kg">kikongo</option><option value="rw">kinyarwanda</option><option value="ky">kirgiski</option><option value="ktu">kituba</option><option value="trp">kokborok</option><option value="kv">komi</option><option value="gom">konkani</option><option value="ko">koreański</option><option value="co">korsykański</option><option value="ht">kreolski (Haiti)</option><option value="mfe">kreolski (Mauritius)</option><option value="crs">kreolski (Seszele)</option><option value="kri">krio</option><option value="crh">krymsko-tatarski</option><option value="ku">kurdyjski (kurmandżi)</option><option value="ckb">kurdyjski (sorani)</option><option value="cnh">lai</option><option value="lo">laotański</option><option value="se">lapoński (północny)</option><option value="lij">liguryjski</option><option value="li">limburski</option><option value="ln">lingala</option><option value="lt">litewski</option><option value="lmo">lombardzki</option><option value="lg">luganda</option><option value="lb">luksemburski</option><option value="luo">luo</option><option value="la">łaciński</option><option value="ltg">łatgalski</option><option value="lv">łotewski</option><option value="mk">macedoński</option><option value="mad">madurski</option><option value="mai">maithili</option><option value="mak">makasarski</option><option value="ml">malajalam</option><option value="ms">malajski</option><option value="ms-Arab">malajski (jawi)</option><option value="mg">malgaski</option><option value="mt">maltański</option><option value="mam">mam</option><option value="gv">manx</option><option value="mi">maoryski</option><option value="mr">marathi</option><option value="mh">marszalski</option><option value="mwr">marwadi</option><option value="yua">maya</option><option value="mni-Mtei">meiteilon (manipuri)</option><option value="min">minang</option><option value="lus">mizo</option><option value="mn">mongolski</option><option value="bm-Nkoo">n'ko</option><option value="nhe">nahuatl (wschodni huasteca)</option><option value="ndc-ZW">ndau</option><option value="nr">ndebele (południowy)</option><option value="ne">nepalski</option><option value="new">newarski (newari)</option><option value="nl">niderlandzki</option><option value="de">niemiecki</option><option value="no">norweski</option><option value="nus">nuer</option><option value="or">odia (orija)</option><option value="oc">oksytański</option><option value="hy">ormiański</option><option value="om">oromo</option><option value="os">osetyjski</option><option value="pam">pampango</option><option value="pag">pangasinan</option><option value="pap">papiamento</option><option value="ps">paszto</option><option value="pa">pendżabski (gurmukhi)</option><option value="pa-Arab">pendżabski (szachmukhi)</option><option value="fa">perski</option><option value="pt">portugalski (Brazylia)</option><option value="pt-PT">portugalski (Portugalia)</option><option value="rom">romski</option><option value="ru">rosyjski</option><option value="ro">rumuński</option><option value="rn">rundi</option><option value="sm">samoański</option><option value="sg">sango</option><option value="sa">sanskryt</option><option value="sat-Latn">santali</option><option value="nso">sepedi</option><option value="sr">serbski</option><option value="st">sesotho</option><option value="sn">shona</option><option value="sd">sindhi</option><option value="sk">słowacki</option><option value="sl">słoweński</option><option value="so">somalijski</option><option value="sw">suahili</option><option value="ss">suazi</option><option value="su">sundajski</option><option value="sus">susu</option><option value="scn">sycylijski</option><option value="si">syngaleski</option><option value="shn">szan</option><option value="gd">szkocki gaelicki</option><option value="sv">szwedzki</option><option value="szl">śląski</option><option value="tg">tadżycki</option><option value="ty">tahitański</option><option value="th">tajski</option><option value="ber-Latn">tamazight</option><option value="ber">tamazight (tifinagh)</option><option value="ta">tamilski</option><option value="tt">tatarski</option><option value="te">telugu</option><option value="tet">tetum</option><option value="ti">tigrinia</option><option value="tiv">tiw</option><option value="tpi">tok pisin</option><option value="to">tonga</option><option value="ts">tsonga</option><option value="tn">tswana</option><option value="tcy">tulu</option><option value="tum">tumbuka</option><option value="tr">turecki</option><option value="tk">turkmeński</option><option value="tyv">tuwiński</option><option value="ak">twi</option><option value="bo">tybetański</option><option value="udm">udmurcki</option><option value="ug">ujgurski</option><option value="uk">ukraiński</option><option value="ur">urdu</option><option value="uz">uzbecki</option><option value="ve">venda</option><option value="cy">walijski</option><option value="war">warajski</option><option value="vec">wenecki</option><option value="hu">węgierski</option><option value="vi">wietnamski</option><option value="it">włoski</option><option value="wo">wolof</option><option value="chm">wschodniomaryjski</option><option value="xh">xhosa</option><option value="zap">zapotecki</option><option value="zu">zulu</option></select></div>Technologia <span style="white-space:nowrap"><a class="VIpgJd-ZVi9od-l4eHX-hSRGPd" href="https://translate.google.com" target="_blank"><img src="https://www.gstatic.com/images/branding/googlelogo/1x/googlelogo_color_42x16dp.png" width="37px" height="14px" style="padding-right: 3px" alt="Google Tłumacz">Tłumacz</a></span></div></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<main>
    {{ $slot }}
</main>
</body>
</html>
