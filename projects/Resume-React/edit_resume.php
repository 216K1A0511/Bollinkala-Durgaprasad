<!DOCTYPE html>
<html lang="en">
<head>
  <title>Resume Builder · Resume.io</title>
  <meta name="robots" content="noindex">
  <meta content="width=device-width, viewport-fit=cover" name="viewport" />
  <meta content="Resume.io" name="apple-mobile-web-app-title" />
  <meta content="yes" name="apple-mobile-web-app-capable" />
  <meta content="white" name="apple-mobile-web-app-status-bar-style" />
  <link href="/app/manifest.json" rel="manifest" />
  <link rel="icon" type="image/x-icon" href="/assets/favicon/resume/favicon-370eedaf612a0ee315e4f32878253e4e0f900ff318654809a96e9a06db77d1af.ico" sizes="any" />
  <link rel="icon" type="image/svg+xml" href="/assets/favicon/resume/favicon-ebca70e4713ae491d50ce36cecf86663d8cc6790d3938049d342cd49be90fa7f.svg" />
  <link rel="apple-touch-icon" type="image/x-icon" href="/assets/favicon/resume/apple-touch-icon-3ccd76658da45cd5fb1f5bd43cf8614fda9b56d1b24ba948331622539c83d219.png" />

  <!-- Google Tag Manager + dataLayer -->
  <script type="text/javascript">
    dataLayer = [{
      "userId":45619190,
      "userEmail":"manikiranbuddala1231@gmail.com",
      "userEmailEnc":"e096e773fc385868cb96bc679567c1975ab0e98e",
      "countryId":2,
      "countryHost":"resume.io",
      "vanityABTestTag":"cta_homepage_redirection_locals:test",
      "googleOptimizeExperiment":""
    }];

    function gtag(){dataLayer.push(arguments);}

    gtag('consent', 'default', {
      'ad_storage': 'granted',
      'analytics_storage': 'granted',
      'ad_user_data': 'granted',
      'ad_personalization': 'granted',
    });

    window.uetq = window.uetq || [];
    window.uetq.push('consent', 'default', {
      'ad_storage': 'granted',
      'analytics_storage': 'granted',
      'personalization_storage': 'granted',
      'functional_storage': 'granted',
      'security_storage': 'granted'
    });

    dataLayer.push({ event: 'AcceptCookies' });

    (function(w,d,s,l,i){
      w[l]=w[l]||[];
      w[l].push({'gtm.start': new Date().getTime(), event:'gtm.js'});
      var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
      j.async=true;
      j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
      f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P89SGK');
  </script>

  <!-- JSON-LD Organization data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Resume.io",
    "url": "https://resume.io",
    "logo": "https://s3.resume.io/uploads/country/logo_default/2/black.svg",
    "description": "At Resume.io we believe that building a job-worthy resume should be a fast and simple process. In fact, we’ve always been about building systems that are quick and easy-to-use, yet consistently get good results. Our mission is to help job seekers grow careers. We love helping people stand out in their job search and get hired faster."
  }
  </script>

  <!-- Builder JS + CSS -->
  <script src="/assets/js/builder-2f1b45f717b589f7101c357b4e1d0d08745dd373cafd1676f3481a440c899a68.js"
          defer="defer"
          type="text/javascript">
  </script>
  <link rel="stylesheet"
        media="all"
        href="/assets/css/builder-1f34b9d03f09732be830ebe1fb70baa8749cb3a1afba8f15dff87367c5c6123d.css" />

  <!-- Start VWO Async SmartCode -->
  <link rel="preconnect" href="https://dev.visualwebsiteoptimizer.com" />
  <script type="text/javascript" data-cfasync="false" id="vwoCode">
    window._vwo_code || (function() {
      var account_id = 1000014,
          version = 2.1,
          settings_tolerance = 2000,
          hide_element = 'body',
          hide_element_style = 'opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;transition:none !important;',
          f = false,
          w = window,
          d = document,
          v = d.querySelector('#vwoCode'),
          cK = '_vwo_' + account_id + '_settings',
          cc = {};

      try {
        var c = JSON.parse(localStorage.getItem('_vwo_' + account_id + '_config'));
        cc = c && typeof c === 'object' ? c : {};
      } catch (e) {}

      var stT = cc.stT === 'session' ? w.sessionStorage : w.localStorage;
      code = {
        nonce: v && v.nonce,
        use_existing_jquery: function() {
          return typeof use_existing_jquery !== 'undefined' ? use_existing_jquery : undefined;
        },
        library_tolerance: function() {
          return typeof library_tolerance !== 'undefined' ? library_tolerance : undefined;
        },
        settings_tolerance: function() {
          return cc.sT || settings_tolerance;
        },
        hide_element_style: function() {
          return '{' + (cc.hES || hide_element_style) + '}';
        },
        hide_element: function() {
          if (performance.getEntriesByName('first-contentful-paint')[0]) {
            return '';
          }
          return typeof cc.hE === 'string' ? cc.hE : hide_element;
        },
        getVersion: function() {
          return version;
        },
        finish: function(e) {
          if (!f) {
            f = true;
            var t = d.getElementById('_vis_opt_path_hides');
            if (t) t.parentNode.removeChild(t);
            if (e)(new Image).src = 'https://dev.visualwebsiteoptimizer.com/ee.gif?a=' + account_id + e;
          }
        },
        finished: function() {
          return f;
        },
        addScript: function(e) {
          var t = d.createElement('script');
          t.type = 'text/javascript';
          if (e.src) {
            t.src = e.src;
          } else {
            t.text = e.text;
          }
          v && t.setAttribute('nonce', v.nonce);
          d.getElementsByTagName('head')[0].appendChild(t);
        },
        load: function(e, t) {
          var n = this.getSettings(),
              i = d.createElement('script'),
              r = this;
          t = t || {};
          if (n) {
            i.textContent = n;
            d.getElementsByTagName('head')[0].appendChild(i);
            if (!w.VWO || VWO.caE) {
              stT.removeItem(cK);
              r.load(e);
            }
          } else {
            var o = new XMLHttpRequest();
            o.open('GET', e, true);
            o.withCredentials = !t.dSC;
            o.responseType = t.responseType || 'text';
            o.onload = function() {
              if (t.onloadCb) {
                return t.onloadCb(o, e);
              }
              if (o.status === 200 || o.status === 304) {
                _vwo_code.addScript({ text: o.responseText });
              } else {
                _vwo_code.finish('&e=loading_failure:' + e);
              }
            };
            o.onerror = function() {
              if (t.onerrorCb) {
                return t.onerrorCb(e);
              }
              _vwo_code.finish('&e=loading_failure:' + e);
            };
            o.send();
          }
        },
        getSettings: function() {
          try {
            var e = stT.getItem(cK);
            if (!e) {
              return;
            }
            e = JSON.parse(e);
            if (Date.now() > e.e) {
              stT.removeItem(cK);
              return;
            }
            return e.s;
          } catch (e) {
            return;
          }
        },
        init: function() {
          if (d.URL.indexOf('__vwo_disable__') > -1) return;
          var e = this.settings_tolerance();
          w._vwo_settings_timer = setTimeout(function() {
            _vwo_code.finish();
            stT.removeItem(cK);
          }, e);

          var t;
          if (this.hide_element() !== 'body') {
            t = d.createElement('style');
            var n = this.hide_element(),
                i = n ? n + this.hide_element_style() : '',
                r = d.getElementsByTagName('head')[0];
            t.setAttribute('id', '_vis_opt_path_hides');
            v && t.setAttribute('nonce', v.nonce);
            t.setAttribute('type', 'text/css');
            if (t.styleSheet) t.styleSheet.cssText = i;
            else t.appendChild(d.createTextNode(i));
            r.appendChild(t);
          } else {
            t = d.getElementsByTagName('head')[0];
            var i = d.createElement('div');
            i.style.cssText = 'z-index: 2147483647 !important;position: fixed !important;left: 0 !important;top: 0 !important;width: 100% !important;height: 100% !important;background: white !important;display: block !important;';
            i.setAttribute('id', '_vis_opt_path_hides');
            i.classList.add('_vis_hide_layer');
            t.parentNode.insertBefore(i, t.nextSibling);
          }

          var o = window._vis_opt_url || d.URL,
              s = 'https://dev.visualwebsiteoptimizer.com/j.php?a=' + account_id + '&u=' + encodeURIComponent(o) + '&vn=' + version;
          if (w.location.search.indexOf('_vwo_xhr') !== -1) {
            this.addScript({ src: s });
          } else {
            this.load(s + '&x=true');
          }
        }
      };
      w._vwo_code = code;
      code.init();

      var vwo_account_id = "", vwo_uuid = "";
      window.VWO = window.VWO || [];
      VWO.push([
        "onVariationApplied",
        function (data) {
          vwo_account_id = window._vwo_acc_id;
          var experiment_id = data[1],
              variant_id = data[2];
          vwo_uuid = VWO._ && VWO._.cookies && VWO._.cookies.get("_vwo_uuid");

          if (
            _vwo_exp[experiment_id].comb_n[variant_id] &&
            ["VISUAL_AB", "VISUAL", "SPLIT_URL"].indexOf(_vwo_exp[experiment_id].type) > -1
          ) {
            var vwo_data = {
              account_id: vwo_account_id,
              experiment_id: experiment_id,
              experiment_name: window._vwo_exp[experiment_id].name,
              variation_id: variant_id,
              variation_name: window._vwo_exp[experiment_id].comb_n[variant_id],
              user_id: vwo_uuid
            };

            fetch('/vwo_client_campaigns', {
              method: 'POST',
              headers: {'Content-Type': 'application/json'},
              body: JSON.stringify(vwo_data)
            });
          }
        }
      ]);
    })();
  </script>
  <!-- End VWO Async SmartCode -->
</head>
<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P89SGK"
            height="0"
            width="0"
            style="display:none;visibility:hidden">
    </iframe>
  </noscript>

  <!-- The main application container -->
  <div id="builder-application"></div>

  <!-- Helpscout Beacon -->
  <script type="text/javascript">
    !(function(e, t, n) {
      function a() {
        var e = t.getElementsByTagName("script")[0],
            n = t.createElement("script");
        n.type = "text/javascript",
        n.async = !0,
        n.src = "https://beacon-v2.helpscout.net",
        e.parentNode.insertBefore(n, e);
      }
      if(((e.Beacon = n = function(t, n, a){
        e.Beacon.readyQueue.push({ method: t, options: n, data: a });
      }),
      (n.readyQueue = []),
      "complete" === t.readyState)) return a();
      e.attachEvent ? e.attachEvent("onload", a) : e.addEventListener("load", a, !1);
    })(window, document, window.Beacon || function() {});

    Beacon("init", "a4bf783e-2ea3-4050-a7e0-e3a190ac45e4");
    Beacon("identify", {"name":"B.M Kiran","email":"manikiranbuddala1231@gmail.com"});
  </script>

  <!-- Cloudflare Rocket Loader -->
  <script
    src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
    data-cf-settings="50c6bcc0c4a5af021e76ada5-|49"
    defer>
  </script>
</body>
</html>
