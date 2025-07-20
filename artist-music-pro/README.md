# Artist Music Pro WordPress Theme

A modern and fantastic WordPress theme with RTL support and Farsi fonts, specifically designed for artists and singer-songwriters.

## Features

### 🎵 Music-Focused Design
- **Built-in Music Player**: Advanced HTML5 audio player with playlist support
- **Custom Post Types**: 
  - Music tracks with metadata (duration, genre, album, etc.)
  - Albums with streaming platform links
- **Music Widgets**: Recent tracks, featured music carousel
- **Album Artwork Support**: Beautiful image displays for tracks and albums

### 🌍 Multilingual & RTL Support
- **Full RTL Support**: Complete right-to-left language support
- **Farsi/Persian Fonts**: 
  - Primary: Vazirmatn (modern Persian font)
  - Secondary: Noto Sans Arabic
  - Fallback: Inter, system fonts
- **Language Toggle**: Built-in RTL/LTR switching functionality
- **Translation Ready**: Full i18n support with .pot file

### 🎨 Modern Design
- **Responsive Design**: Mobile-first, fully responsive layout
- **Dark Mode Support**: Automatic dark mode based on system preferences
- **Beautiful Animations**: Smooth scroll animations and transitions
- **Custom Color Schemes**: Customizable via WordPress Customizer
- **Professional Typography**: Optimized for both Latin and Arabic scripts

### 🚀 Performance & Accessibility
- **Fast Loading**: Optimized CSS and JavaScript
- **SEO Friendly**: Semantic HTML5 structure
- **Accessibility Ready**: ARIA labels, keyboard navigation
- **Web Fonts Optimization**: Preloaded fonts for better performance

## Installation

1. **Download the theme files**
2. **Upload to WordPress**:
   - Via Admin: `Appearance > Themes > Add New > Upload Theme`
   - Via FTP: Upload to `/wp-content/themes/artist-music-theme/`
3. **Activate the theme** from `Appearance > Themes`

## Setup Guide

### Initial Configuration

1. **Go to Customizer** (`Appearance > Customize`)
2. **Configure Hero Section**:
   - Set hero title and subtitle
   - Upload background image (optional)
3. **Set up Social Media**:
   - Add your social media URLs
   - Supports: Facebook, Instagram, Twitter, YouTube, Spotify, SoundCloud, etc.
4. **Configure Colors**:
   - Primary color (default: #1a1a1a)
   - Secondary color (default: #ff6b35)
   - Accent color (default: #ffd700)

### Adding Music Content

#### Creating Music Tracks
1. Go to `Music > Add New`
2. Add track title and description
3. Set featured image (album artwork)
4. Fill in track details:
   - Audio File URL (direct link to MP3/audio file)
   - Album Name
   - Duration (e.g., "3:45")
   - Genre
   - Release Date
   - Mark as Featured (to show on homepage)

#### Creating Albums
1. Go to `Albums > Add New`
2. Add album title and description
3. Set featured image (album cover)
4. Fill in album details:
   - Release Year
   - Genre
   - Record Label
   - Spotify URL
   - Apple Music URL

### Menu Setup

1. **Create Menus** (`Appearance > Menus`)
2. **Primary Menu**: Main navigation (assigned to "Primary Menu" location)
3. **Footer Menu**: Footer links (assigned to "Footer Menu" location)

### Widget Areas

The theme includes several widget areas:
- **Sidebar**: Right sidebar for blog posts
- **Footer Widget Areas**: 3 footer columns

#### Custom Widgets Included:
- **Recent Tracks**: Shows latest music with play buttons
- **Social Media Links**: Displays social media icons
- **About Artist**: Artist bio with photo

## RTL & Farsi Support

### Automatic Detection
The theme automatically detects RTL languages and applies appropriate styles.

### Manual Toggle
Users can manually switch between RTL and LTR using the language toggle button in the header.

### Farsi Font Support
- **Vazirmatn**: Modern, web-optimized Persian font
- **Proper Line Heights**: Optimized for Persian text readability
- **Number Support**: Handles both Western and Persian numerals

## File Structure

```
artist-music-theme/
├── style.css                 # Main stylesheet with theme info
├── rtl.css                  # RTL-specific styles
├── index.php                # Main template file
├── header.php               # Header template
├── footer.php               # Footer template
├── functions.php            # Theme functions and setup
├── assets/
│   ├── css/                 # Additional stylesheets
│   ├── js/
│   │   ├── theme.js         # Main theme JavaScript
│   │   ├── music-player.js  # Music player functionality
│   │   └── navigation.js    # Navigation scripts
│   └── images/              # Theme images
├── inc/
│   ├── customizer.php       # WordPress Customizer settings
│   ├── template-functions.php # Theme helper functions
│   ├── template-tags.php    # Template tags
│   └── widgets.php          # Custom widgets
├── languages/               # Translation files
└── README.md               # This file
```

## Customization

### CSS Variables
The theme uses CSS custom properties for easy customization:

```css
:root {
    --primary-color: #1a1a1a;
    --secondary-color: #ff6b35;
    --accent-color: #ffd700;
    --font-primary: 'Vazirmatn', sans-serif;
    --font-display: 'Vazirmatn', serif;
}
```

### Child Theme
For extensive customizations, create a child theme:

1. Create new folder: `artist-music-child`
2. Add `style.css` with theme header
3. Add `functions.php` to enqueue parent styles

## Music Player API

The theme includes a JavaScript API for the music player:

```javascript
// Play a track
musicPlayer.play(audioUrl, trackTitle, artistName);

// Toggle play/pause
musicPlayer.toggle();

// Get current track
const currentTrack = musicPlayer.getCurrentTrack();

// Check if playing
const isPlaying = musicPlayer.isPlaying();
```

## Browser Support

- **Modern Browsers**: Chrome 60+, Firefox 60+, Safari 12+, Edge 79+
- **Mobile**: iOS Safari 12+, Chrome Mobile 60+
- **RTL Support**: All modern browsers with proper RTL rendering

## Performance

- **Optimized Loading**: CSS and JS are minified and optimized
- **Font Loading**: Uses `font-display: swap` for better performance
- **Image Optimization**: Responsive images with proper sizing
- **Lazy Loading**: Built-in WordPress lazy loading support

## Accessibility

- **ARIA Labels**: Proper labeling for screen readers
- **Keyboard Navigation**: Full keyboard support
- **Color Contrast**: WCAG AA compliant color ratios
- **Focus Management**: Visible focus indicators
- **Screen Reader Support**: Optimized for assistive technologies

## SEO Features

- **Semantic HTML5**: Proper document structure
- **Schema Markup**: Rich snippets for music content
- **Open Graph**: Social media sharing optimization
- **Meta Tags**: Proper meta tag implementation
- **Clean URLs**: SEO-friendly permalink structure

## Support & Updates

### Customizer Options
All major theme options are available in the WordPress Customizer:
- Hero section content
- Colors and typography
- Social media links
- Contact information
- Footer content

### Developer Hooks
The theme provides action and filter hooks for developers:
- `artist_music_pro_header`
- `artist_music_pro_footer`
- `artist_music_pro_before_content`
- `artist_music_pro_after_content`

## Credits

- **Fonts**: 
  - Vazirmatn by Saber Rastikerdar
  - Noto Sans Arabic by Google Fonts
  - Inter by Rasmus Andersson
- **Icons**: Custom SVG icons
- **Inspiration**: Modern music websites and Persian typography

## License

This theme is licensed under the GPL v2 or later.

## Changelog

### Version 1.0.0
- Initial release
- RTL support with Farsi fonts
- Music player functionality
- Custom post types for music and albums
- Responsive design
- WordPress Customizer integration
- Custom widgets
- Accessibility features

---

**Created with ♪ for music lovers**
