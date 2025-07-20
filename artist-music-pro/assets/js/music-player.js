/**
 * Artist Music Pro - Music Player JavaScript
 * Advanced music player functionality
 */

(function($) {
    'use strict';

    let currentTrack = null;
    let isPlaying = false;
    let audioPlayer = null;
    let playlist = [];
    let currentTrackIndex = 0;

    // Initialize the music player when document is ready
    $(document).ready(function() {
        initMusicPlayer();
        initPlaylistControls();
        bindPlayerEvents();
        loadPlaylist();
    });

    /**
     * Initialize the main music player
     */
    function initMusicPlayer() {
        audioPlayer = document.getElementById('audio-player');
        
        if (!audioPlayer) {
            console.warn('Audio player element not found');
            return;
        }

        // Audio player event listeners
        audioPlayer.addEventListener('loadedmetadata', updatePlayerInfo);
        audioPlayer.addEventListener('timeupdate', updateProgress);
        audioPlayer.addEventListener('ended', handleTrackEnd);
        audioPlayer.addEventListener('error', handleAudioError);
        audioPlayer.addEventListener('loadstart', showLoadingState);
        audioPlayer.addEventListener('canplaythrough', hideLoadingState);

        // Initialize progress bar interaction
        initProgressBar();
    }

    /**
     * Initialize playlist controls
     */
    function initPlaylistControls() {
        // Play/pause button
        $('.play-btn').on('click', function(e) {
            e.preventDefault();
            togglePlayPause();
        });

        // Track buttons in music cards
        $('.music-card .btn').on('click', function(e) {
            e.preventDefault();
            const trackUrl = $(this).data('track-url');
            const trackTitle = $(this).closest('.music-card').find('h3').text();
            const trackArtist = $(this).closest('.music-card').find('.artist-name').text() || $('body').data('artist-name') || 'Unknown Artist';
            
            if (trackUrl) {
                playTrack(trackUrl, trackTitle, trackArtist);
            }
        });

        // Volume control (if implemented)
        if ($('.volume-control').length) {
            initVolumeControl();
        }

        // Keyboard controls
        $(document).on('keydown', function(e) {
            if (e.target.tagName.toLowerCase() !== 'input' && e.target.tagName.toLowerCase() !== 'textarea') {
                switch(e.keyCode) {
                    case 32: // Spacebar
                        e.preventDefault();
                        togglePlayPause();
                        break;
                    case 37: // Left arrow
                        e.preventDefault();
                        seekBackward();
                        break;
                    case 39: // Right arrow
                        e.preventDefault();
                        seekForward();
                        break;
                }
            }
        });
    }

    /**
     * Global function to play a track
     */
    window.playTrack = function(url, title, artist) {
        if (!audioPlayer) {
            console.error('Audio player not initialized');
            return;
        }

        // Update current track info
        currentTrack = {
            url: url,
            title: title,
            artist: artist || 'Unknown Artist'
        };

        // Load and play the track
        audioPlayer.src = url;
        audioPlayer.load();
        
        // Update UI
        updateTrackInfo(title, artist);
        
        // Play the track
        audioPlayer.play().then(() => {
            isPlaying = true;
            updatePlayButton();
        }).catch((error) => {
            console.error('Error playing track:', error);
            showError('Unable to play this track');
        });
    };

    /**
     * Global function to toggle play/pause
     */
    window.togglePlay = function() {
        togglePlayPause();
    };

    /**
     * Toggle play/pause state
     */
    function togglePlayPause() {
        if (!audioPlayer || !currentTrack) {
            return;
        }

        if (isPlaying) {
            audioPlayer.pause();
            isPlaying = false;
        } else {
            audioPlayer.play().then(() => {
                isPlaying = true;
            }).catch((error) => {
                console.error('Error playing track:', error);
                showError('Unable to play this track');
            });
        }
        
        updatePlayButton();
    }

    /**
     * Update play button appearance
     */
    function updatePlayButton() {
        const playBtn = $('.play-btn');
        if (isPlaying) {
            playBtn.html('⏸'); // Pause symbol
            playBtn.attr('title', 'Pause');
        } else {
            playBtn.html('▶'); // Play symbol
            playBtn.attr('title', 'Play');
        }
    }

    /**
     * Update track information display
     */
    function updateTrackInfo(title, artist) {
        $('#current-track').text(title);
        $('#current-artist').text(artist);
        
        // Update page title if playing
        if (title && artist) {
            document.title = `♪ ${title} - ${artist} | ${$('body').data('site-name') || 'Artist Music Pro'}`;
        }
    }

    /**
     * Update progress bar
     */
    function updateProgress() {
        if (!audioPlayer || audioPlayer.duration === 0) return;

        const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        $('#progress').css('width', progress + '%');
        
        // Update time display if elements exist
        updateTimeDisplay();
    }

    /**
     * Update time display
     */
    function updateTimeDisplay() {
        const currentTime = formatTime(audioPlayer.currentTime);
        const duration = formatTime(audioPlayer.duration);
        
        $('.current-time').text(currentTime);
        $('.total-time').text(duration);
    }

    /**
     * Format time for display
     */
    function formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    /**
     * Initialize progress bar interaction
     */
    function initProgressBar() {
        const progressBar = $('.progress-bar');
        
        if (!progressBar.length) return;

        progressBar.on('click', function(e) {
            if (!audioPlayer || !audioPlayer.duration) return;

            const rect = this.getBoundingClientRect();
            const percent = (e.clientX - rect.left) / rect.width;
            const newTime = percent * audioPlayer.duration;
            
            audioPlayer.currentTime = newTime;
        });

        // Touch support for mobile
        progressBar.on('touchstart', function(e) {
            e.preventDefault();
        });

        progressBar.on('touchmove', function(e) {
            if (!audioPlayer || !audioPlayer.duration) return;
            
            e.preventDefault();
            const touch = e.originalEvent.touches[0];
            const rect = this.getBoundingClientRect();
            const percent = Math.max(0, Math.min(1, (touch.clientX - rect.left) / rect.width));
            const newTime = percent * audioPlayer.duration;
            
            audioPlayer.currentTime = newTime;
        });
    }

    /**
     * Initialize volume control
     */
    function initVolumeControl() {
        const volumeSlider = $('.volume-slider');
        
        volumeSlider.on('input', function() {
            if (audioPlayer) {
                audioPlayer.volume = $(this).val() / 100;
            }
        });

        // Mute button
        $('.mute-btn').on('click', function() {
            if (audioPlayer) {
                audioPlayer.muted = !audioPlayer.muted;
                $(this).toggleClass('muted', audioPlayer.muted);
            }
        });
    }

    /**
     * Handle track end
     */
    function handleTrackEnd() {
        isPlaying = false;
        updatePlayButton();
        
        // Auto-play next track if in playlist mode
        if (playlist.length > 1) {
            playNextTrack();
        }
    }

    /**
     * Handle audio errors
     */
    function handleAudioError() {
        console.error('Audio playback error');
        showError('Error playing audio file');
        isPlaying = false;
        updatePlayButton();
    }

    /**
     * Show loading state
     */
    function showLoadingState() {
        $('.music-player').addClass('loading');
        $('.play-btn').prop('disabled', true);
    }

    /**
     * Hide loading state
     */
    function hideLoadingState() {
        $('.music-player').removeClass('loading');
        $('.play-btn').prop('disabled', false);
    }

    /**
     * Show error message
     */
    function showError(message) {
        // Create or update error notification
        let errorNotification = $('.audio-error');
        
        if (!errorNotification.length) {
            errorNotification = $('<div class="audio-error"></div>');
            $('.music-player').append(errorNotification);
        }
        
        errorNotification.text(message).fadeIn();
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
            errorNotification.fadeOut();
        }, 3000);
    }

    /**
     * Load playlist from page data
     */
    function loadPlaylist() {
        playlist = [];
        
        $('.music-card').each(function() {
            const trackUrl = $(this).find('.btn').data('track-url');
            const title = $(this).find('h3').text();
            const artist = $(this).find('.artist-name').text() || 'Unknown Artist';
            
            if (trackUrl) {
                playlist.push({
                    url: trackUrl,
                    title: title,
                    artist: artist,
                    element: $(this)
                });
            }
        });
    }

    /**
     * Play next track in playlist
     */
    function playNextTrack() {
        if (playlist.length === 0) return;
        
        currentTrackIndex = (currentTrackIndex + 1) % playlist.length;
        const nextTrack = playlist[currentTrackIndex];
        
        playTrack(nextTrack.url, nextTrack.title, nextTrack.artist);
    }

    /**
     * Play previous track in playlist
     */
    function playPreviousTrack() {
        if (playlist.length === 0) return;
        
        currentTrackIndex = currentTrackIndex === 0 ? playlist.length - 1 : currentTrackIndex - 1;
        const prevTrack = playlist[currentTrackIndex];
        
        playTrack(prevTrack.url, prevTrack.title, prevTrack.artist);
    }

    /**
     * Seek forward 10 seconds
     */
    function seekForward() {
        if (audioPlayer && audioPlayer.duration) {
            audioPlayer.currentTime = Math.min(audioPlayer.currentTime + 10, audioPlayer.duration);
        }
    }

    /**
     * Seek backward 10 seconds
     */
    function seekBackward() {
        if (audioPlayer) {
            audioPlayer.currentTime = Math.max(audioPlayer.currentTime - 10, 0);
        }
    }

    /**
     * Update player info when metadata loads
     */
    function updatePlayerInfo() {
        if (audioPlayer && audioPlayer.duration) {
            updateTimeDisplay();
        }
    }

    /**
     * Bind additional player events
     */
    function bindPlayerEvents() {
        // Play/pause on spacebar when player is focused
        $('.music-player').on('keydown', function(e) {
            if (e.keyCode === 32) { // Spacebar
                e.preventDefault();
                togglePlayPause();
            }
        });

        // Visual feedback for player interaction
        $('.play-btn').on('mousedown', function() {
            $(this).addClass('active');
        });

        $(document).on('mouseup', function() {
            $('.play-btn').removeClass('active');
        });
    }

    // Export functions for external use
    window.musicPlayer = {
        play: playTrack,
        toggle: togglePlayPause,
        next: playNextTrack,
        previous: playPreviousTrack,
        seekForward: seekForward,
        seekBackward: seekBackward,
        getCurrentTrack: function() { return currentTrack; },
        isPlaying: function() { return isPlaying; }
    };

})(jQuery);