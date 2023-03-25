"use strict";

/* eslint-env browser */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var hamburger = document.querySelector('.js-hamburger');

    var hamburgerMenu = function hamburgerMenu() {
      document.getElementsByTagName('html')[0].classList.toggle('is-fixed');
      document.querySelector('.js-navs').classList.toggle('is-open');
    };

    if (hamburger) {
      hamburger.addEventListener('click', hamburgerMenu, false);
    }

    var navigation = document.querySelector('.js-navigation');
    var topDistance = navigation.offsetHeight;
    var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
    /**
     * stickyNavigation function
     */

    function stickyNavigation() {
      if (window.scrollY >= topDistance + 10) {
        navigation.classList.add('js-fixed-nav');

        if (window.scrollY >= 2) {
          document.body.classList.add('js-fixed-animate');
        }
      } else {
        document.body.classList.remove('js-fixed-animate');
        navigation.classList.remove('js-fixed-nav');
        document.body.style.marginTop = 0;
      }
    }

    window.addEventListener('scroll', stickyNavigation);
    var options = {
      speed: 1000,
      easing: 'easeInOutCubic'
    };
    var scroll = new window.SmoothScroll('.js-scroll', {
      offset: 100,
      speed: 1000,
      updateURL: false
    });

    if (scroll) {
      scroll.animateScroll(options);
    } // Copy URL Action


    var copyCode = document.querySelectorAll('.js-copy-code');

    if (copyCode) {
      for (var d = 0; d < copyCode.length; d++) {
        var elem = copyCode[d];

        elem.onclick = function (e) {
          var inputc = e.target.appendChild(document.createElement("input"));
          inputc.value = window.location.href;
          inputc.focus();
          inputc.select();

          try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'Copied!' : 'Failed!';
            e.target.innerHTML = msg;
            setTimeout(function () {
              e.target.innerHTML = 'Copy';
            }, 2500);
          } catch (err) {// Show error
          }
        };
      }
    }
  });
  var cta_btn_subscibe = document.querySelector('a.js-cta-disable');
  cta_btn_subscibe.addEventListener('click', function (e) {
    e.preventDefault();
  });
})();