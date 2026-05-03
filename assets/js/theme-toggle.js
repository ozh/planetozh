( function() {
    'use strict';

    var STORAGE_KEY = 'planetozh-theme';
    var html        = document.documentElement;

    function getIcon() {
        return document.getElementById( 'theme-icon' );
    }

    function setIcon( theme ) {
        var icon = getIcon();
        if ( icon ) {
            icon.textContent = theme === 'dark' ? '☀️' : '🌙';
        }
    }

    function applyTheme( theme ) {
        html.setAttribute( 'data-theme', theme );
        setIcon( theme );
    }

    // Apply saved or system preference - script is in footer so DOM is ready
    var saved = localStorage.getItem( STORAGE_KEY );
    if ( saved ) {
        applyTheme( saved );
    } else if ( window.matchMedia && window.matchMedia( '(prefers-color-scheme: dark)' ).matches ) {
        applyTheme( 'dark' );
    } else {
        setIcon( 'light' );
    }

    // Toggle on click
    var toggle = document.getElementById( 'theme-toggle' );
    if ( toggle ) {
        toggle.addEventListener( 'click', function() {
            var isDark = html.getAttribute( 'data-theme' ) === 'dark';
            var next   = isDark ? 'light' : 'dark';
            applyTheme( next );
            localStorage.setItem( STORAGE_KEY, next );
        } );
    }

    // Sync with system preference changes (only if no saved preference)
    if ( window.matchMedia ) {
        window.matchMedia( '(prefers-color-scheme: dark)' ).addEventListener( 'change', function( e ) {
            if ( ! localStorage.getItem( STORAGE_KEY ) ) {
                applyTheme( e.matches ? 'dark' : 'light' );
            }
        } );
    }

    // =====================================================
    // STAMP: migrate from hero to header on scroll
    // =====================================================
    var siteHeader = document.getElementById( 'site-header' );
    var hero       = document.getElementById( 'hero' );

    if ( siteHeader ) {
        if ( ! hero ) {
            // No hero on this page: show stamp in header immediately
            siteHeader.classList.add( 'stamp-visible' );
        } else {
            // Hero present: watch when hero scrolls behind the sticky header
            // rootMargin -58px = header height
            var observer = new IntersectionObserver(
                function( entries ) {
                    siteHeader.classList.toggle( 'stamp-visible', ! entries[0].isIntersecting );
                },
                { threshold: 0, rootMargin: '-58px 0px 0px 0px' }
            );
            observer.observe( hero );
        }
    }

    // Footer planet orbit animation
    var footerPlanet = document.getElementById( 'footer-planet' );

    if ( footerPlanet ) {
        var letters    = footerPlanet.querySelectorAll( '.pl' );
        var radius     = 46;
        var numLetters = letters.length;
        var angleOffset = 0;
        var animFrame;
        var isHovered  = false;
        var speed      = 0.018; // radians per frame

        function drawOrbit() {
            angleOffset += speed;
            letters.forEach( function( el, i ) {
                var angle = angleOffset + ( i / numLetters ) * Math.PI * 2;
                var x = Math.cos( angle ) * radius;
                var y = Math.sin( angle ) * radius * 0.38; // aplatir = ellipse = orbite
                var scale = 0.75 + ( ( Math.sin( angle ) + 1 ) / 2 ) * 0.4; // zoom selon z
                el.style.transform = 'translate( calc(-50% + ' + x + 'px), calc(-50% + ' + y + 'px) ) scale(' + scale + ')';
                el.style.zIndex    = Math.sin( angle ) > 0 ? 3 : 1; // devant/derrière Ozh
                el.style.opacity   = isHovered ? ( 0.5 + ( ( Math.sin( angle ) + 1 ) / 2 ) * 0.5 ) : 0;
            } );
            animFrame = requestAnimationFrame( drawOrbit );
        }

        footerPlanet.addEventListener( 'mouseenter', function() {
            isHovered = true;
            if ( ! animFrame ) drawOrbit();
        } );

        footerPlanet.addEventListener( 'mouseleave', function() {
            isHovered = false;
            // Laisse tourner encore un peu avant de s'arrêter
            setTimeout( function() {
                if ( ! isHovered ) {
                    cancelAnimationFrame( animFrame );
                    animFrame = null;
                    letters.forEach( function( el ) { el.style.opacity = 0; } );
                }
            }, 400 );
        } );
    }

} )();
