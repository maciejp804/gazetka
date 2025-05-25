<style>
    .ads-1 {
        position: relative;
        width: 100%;
        padding: 20px 0}
    .ads-1-container {
        position: relative;
        max-width: 750px;
        margin: auto}
    .ad-slot1 { display:inline-block; width: 750px; height: 300px; }
    .ad-desktop {
        display: block;
    }
    .ad-mobile, .ad-mobile-flex{
        display: none;
    }

    @media screen and (max-width:768px) { .ad-desktop { display: none }
        .ad-mobile {
            display: block;}
        .ad-mobile-flex{
            display: flex;
        } }

    .ad-slot2 { display:inline-block; width: 200px; height: 200px; }
    @media (max-width:970px)  { .ad-slot2 { width: 750px; height: 250px; } }
    @media (max-width:768px)  { .ad-slot2 { width: 250px; height: 250px; } }
    @media (max-width:480px) { .ad-slot2 { width: 336px; height: 280px; } }
    @media (max-width:375px) { .ad-slot2 { width: 300px; height: 250px; } }
    .left-sidebar{
        width: 23%;
        display: flex;
        flex-direction: column;
    }
    .ads-4{
        width: 100%;
        margin: 0px 0;
        max-width: 300px;
        float: left}
    .ads-4-container {
        position: relative;
        width: 100%;
        max-width: 300px;
        margin: auto}
    .ad-slot4 { display:inline-block; width: 300px; height: 600px; }
    @media (max-width: 1365px)  { .ad-slot4 { width: 160px; height: 600px; } }
    @media (max-width: 768px)  { .ad-slot4 { display: none;}
        .ads-4, .left-sidebar { display: none;}}
    .ads-11 {
        width: 100%;
        padding: 5px 0}
    .ads-11-container {
        position: relative;
        max-width: 750px;
        margin: auto}
    @media (max-width: 767px) { .ads-11 {width: 100%;}
        .ads-11-container {max-width: 468px; }}
    @media (max-width: 479px) { .ads-11-container {max-width: 300px; }}
    .ads-12 {
        width: 100%;
        margin: 20px 0 20px 0;
        height: auto}
    .ads-12-container {
        position: relative;
        max-width: 750px;
        margin: auto}
</style>
<div class="ads-1 ad-desktop">
    <div id="ads-1-container-2" class="ads-1-container">
            <!-- AdSense z fallbackiem do GAM -->
        <ins id="adsense-ad-2" class="adsbygoogle"
             style="display:inline-block;width:750px;height:300px"
             data-ad-client="ca-pub-0504184268109752"
             data-ad-slot="9092204614"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

        <script>
            googletag.cmd.push(function () {
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
            });

            window.addEventListener('load', function () {
                setTimeout(function () {
                    const ad = document.getElementById('adsense-ad-2');
                    if (ad && ad.getAttribute('data-ad-status') === 'unfilled') {
                        console.log('AdSense-2 unfilled – fallback to GAM');

                        ad.style.display = 'none';

                        const fallback = document.createElement('div');
                        fallback.id = 'gam-fallback-2';
                        fallback.style.width = '750px';
                        fallback.style.height = '300px';
                        document.querySelector('#ads-1-container-2').appendChild(fallback);

                        googletag.cmd.push(function () {
                            googletag.defineSlot('/7894359647/baner_750x250', [[750, 300], [750, 250], [750, 200]], 'gam-fallback-2')
                                .addService(googletag.pubads());
                            googletag.display('gam-fallback-2');
                            console.log('Ad loaded');
                        });
                    }
                }, 1500);
            });
        </script>
    </div>
</div>

<div class="ads-1 ad-mobile">
    <div class="ads-1-container">
        <?php $adStatus = date("Y-m-d H:i:s");
        if ($adStatus > "2021-09-30 23:59:59"){ ?>
            <!-- ABF_responsive -->

        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-0504184268109752"
             data-ad-slot="2004052081"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <?php }  ?>
    </div>
</div>
