# 🎵 Artist Music Pro Theme - cPanel Installation Guide

## 📦 **Download & Installation Steps**

### **Method 1: Direct Upload via cPanel File Manager (Recommended)**

#### Step 1: Download the Theme
1. **Download** the `artist-music-pro-theme.zip` file to your computer
2. **Save** it in a location you can easily find (like Desktop or Downloads)

#### Step 2: Access Your cPanel
1. **Login** to your hosting control panel (cPanel)
2. **Navigate** to File Manager in the Files section
3. **Go to** `public_html/wp-content/themes/`

#### Step 3: Upload the Theme
1. **Click Upload** in the File Manager toolbar
2. **Select** the `artist-music-pro-theme.zip` file
3. **Wait** for upload to complete (usually 30-60 seconds)
4. **Go back** to File Manager
5. **Right-click** on the uploaded ZIP file
6. **Select Extract** from the context menu
7. **Extract** to current directory
8. **Delete** the ZIP file after extraction (optional, to save space)

#### Step 4: Verify Installation
1. **Check** that you now have a folder: `public_html/wp-content/themes/artist-music-pro-theme/`
2. **Ensure** all files are present (style.css, index.php, functions.php, etc.)

---

### **Method 2: WordPress Admin Upload**

#### Step 1: Access WordPress Admin
1. **Go to** your website: `yoursite.com/wp-admin`
2. **Login** with your WordPress credentials

#### Step 2: Upload Theme
1. **Navigate** to `Appearance > Themes`
2. **Click** "Add New" button at the top
3. **Click** "Upload Theme" button
4. **Choose File** and select `artist-music-pro-theme.zip`
5. **Click** "Install Now"
6. **Wait** for installation to complete

---

## 🚀 **Activation & Setup**

### Step 1: Activate the Theme
1. **Go to** `Appearance > Themes` in WordPress admin
2. **Find** "Artist Music Pro" theme
3. **Click** "Activate" button

### Step 2: Configure Permalinks (Important!)
1. **Go to** `Settings > Permalinks`
2. **Select** "Post name" or "Custom Structure: /%postname%/"
3. **Click** "Save Changes"
   - This ensures your music and blog pages work correctly

### Step 3: Basic Theme Setup
1. **Go to** `Appearance > Customize`
2. **Configure**:
   - **Site Identity**: Add your logo and site title
   - **Hero Section**: Add your welcome message in Farsi/English
   - **Colors**: Customize your brand colors
   - **Social Media**: Add your social links

### Step 4: Create Essential Pages
Create these pages in `Pages > Add New`:

#### About Page:
- **Title**: About / درباره من
- **Slug**: about
- **Content**: Your artist bio in Farsi/English

#### Contact Page:
- **Title**: Contact / تماس
- **Slug**: contact  
- **Content**: Contact form and information

### Step 5: Set Up Navigation Menu
1. **Go to** `Appearance > Menus`
2. **Create** a new menu called "Main Menu"
3. **Add pages**:
   - Home / خانه
   - Music / موزیک
   - Albums / آلبوم‌ها  
   - Blog / وبلاگ
   - About / درباره
   - Contact / تماس
4. **Assign** to "Primary Menu" location
5. **Save Menu**

---

## 🎵 **Adding Your Content**

### Add Music Tracks:
1. **Go to** `Music > Add New`
2. **Fill in**:
   - Track Title (Farsi/English)
   - Audio File URL
   - Album Name
   - Duration (e.g., "3:45")
   - Genre
   - Featured Image
3. **Check** "Featured" for homepage display
4. **Publish**

### Add Albums:
1. **Go to** `Albums > Add New`
2. **Add**:
   - Album Title
   - Release Date
   - Track Count
   - Album Cover Image
   - Description
3. **Publish**

### Create Blog Posts:
1. **Go to** `Posts > Add New`
2. **Add**:
   - Post Title (Farsi/English)
   - Content with images
   - Featured Image
   - Categories (Music News, Reviews, etc.)
   - Tags
3. **Publish**

---

## 🌐 **RTL/Farsi Configuration**

### Language Settings:
1. **Go to** `Settings > General`
2. **Set** Site Language to Persian (fa_IR) if available
3. **Or** manually toggle RTL using the header button

### Font Display:
- **Automatic**: Theme loads Farsi fonts (Vazirmatn, Noto Sans Arabic)
- **RTL Layout**: All elements automatically adjust for Persian reading

---

## 🛠️ **Troubleshooting**

### Theme Not Showing Up:
- **Check** file permissions (folders: 755, files: 644)
- **Ensure** style.css has proper theme header
- **Verify** all files uploaded correctly

### Music Player Not Working:
- **Check** audio file URLs are accessible
- **Ensure** files are in common formats (MP3, OGG, WAV)
- **Verify** file permissions allow public access

### RTL Issues:
- **Clear** any caching plugins
- **Check** if other plugins conflict with RTL
- **Use** the manual RTL toggle in header

### Performance Issues:
- **Install** a caching plugin (W3 Total Cache, WP Super Cache)
- **Optimize** images before uploading
- **Use** a CDN for audio files if needed

---

## 📋 **Required PHP/WordPress Setup**

### Minimum Requirements:
- **WordPress**: 5.0 or higher
- **PHP**: 7.4 or higher  
- **Memory**: 128MB or higher
- **MySQL**: 5.6 or higher

### Recommended Plugins:
- **Yoast SEO**: For better search optimization
- **Contact Form 7**: For contact forms
- **WP Super Cache**: For performance
- **Akismet**: For spam protection

---

## 🎨 **Customization Options**

### Available in Customizer:
- **Colors**: Primary/Secondary theme colors
- **Typography**: Font choices and sizes  
- **Hero Section**: Main banner content
- **Social Media**: All platform links
- **Footer**: Custom footer content
- **Music Player**: Player settings

### Advanced Customization:
- **Child Theme**: Recommended for code modifications
- **Custom CSS**: Available in Customizer > Additional CSS
- **Widget Areas**: Sidebar and footer widgets

---

## 📞 **Support**

### Getting Help:
1. **Check** README.md for detailed documentation
2. **Review** this installation guide thoroughly
3. **Test** on a staging site first if possible
4. **Backup** your site before making changes

### File Structure:
```
artist-music-pro-theme/
├── style.css (Main stylesheet)
├── index.php (Main template)
├── functions.php (Theme functions)
├── header.php (Site header)
├── footer.php (Site footer)
├── single.php (Blog post template)
├── archive.php (Blog archive)
├── search.php (Search results)
├── sidebar.php (Sidebar widgets)
├── searchform.php (Search form)
├── rtl.css (RTL styles)
├── assets/ (CSS, JS, Images)
├── inc/ (Theme functions)
└── languages/ (Translation files)
```

**🎵 Enjoy your new Artist Music Pro theme with full blog functionality and RTL support! 🎵**

---

*For any issues, make sure all files are uploaded correctly and WordPress is up to date.*