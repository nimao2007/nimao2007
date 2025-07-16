# 🎵 MusicMaker Pro

A comprehensive web application for making music directly in your browser! Create beats, play virtual piano, synthesize sounds, and record your musical creations.

## ✨ Features

### 🎹 Virtual Piano
- Full octave keyboard with white and black keys
- Keyboard shortcuts for playing notes (A-L keys)
- Real-time visual feedback
- Multiple octaves (C4-B5)

### 🥁 Beat Maker
- 16-step sequencer with 5 drum tracks:
  - Kick drum
  - Snare drum
  - Hi-hat
  - Open hat
  - Crash cymbal
- Click to toggle steps on/off
- Visual playback indicator
- Adjustable tempo (60-200 BPM)

### 🎛️ Synthesizer
- Multiple waveforms: Sine, Square, Triangle, Sawtooth
- ADSR envelope controls (Attack & Release)
- Volume control
- Real-time parameter adjustment

### 🎚️ Effects Processor
- Reverb effect
- Delay effect
- Distortion with adjustable intensity
- Low-pass filter with cutoff control

### 🎙️ Recording Capabilities
- Record audio from microphone
- Play back recorded tracks
- Download recordings as WebM files
- Delete unwanted recordings

### 🎮 Controls
- Play/Pause sequencer
- Stop all playback
- Adjustable tempo control
- Keyboard shortcuts for piano playing
- Spacebar for play/pause

## 🚀 Getting Started

### Prerequisites
- Modern web browser with Web Audio API support
- Microphone access (for recording features)

### Installation & Running

1. **Clone the repository:**
   ```bash
   git clone https://github.com/nimao2007/musicmaker-pro.git
   cd musicmaker-pro
   ```

2. **Start a local server (choose one method):**

   **Using Python:**
   ```bash
   python3 -m http.server 8000
   ```

   **Using Node.js (if you have npm):**
   ```bash
   npm install
   npm start
   ```

   **Using npx serve:**
   ```bash
   npx serve .
   ```

3. **Open your browser:**
   - Navigate to `http://localhost:8000` (or the port shown in terminal)

### Usage

1. **Playing Piano:**
   - Click on piano keys or use keyboard shortcuts:
     - A, W, S, E, D, F, T, G, Y, H, U, J, K, O, L
   - Adjust synthesizer settings in real-time

2. **Creating Beats:**
   - Click on the grid squares to activate drum steps
   - Press Play to hear your beat pattern
   - Adjust tempo with the BPM slider

3. **Recording:**
   - Click Record button to start recording
   - Play instruments or sing into microphone
   - Click Stop Recording when finished
   - Manage recordings in the Recording section

4. **Effects:**
   - Adjust effect parameters with the sliders
   - All changes apply in real-time

## 🎯 Keyboard Shortcuts

- **A-L keys**: Play piano notes (C4-D5)
- **Spacebar**: Play/Pause sequencer
- **Mouse**: Click piano keys and drum pads

## 🛠️ Technical Details

- **Frontend**: Vanilla HTML5, CSS3, JavaScript (ES6+)
- **Audio**: Web Audio API
- **Recording**: MediaRecorder API
- **Styling**: Modern CSS with gradients and animations
- **Responsive**: Works on desktop and mobile devices

## 🎨 Design Features

- **Dark theme** with vibrant accent colors
- **Glassmorphism** effects with backdrop blur
- **Smooth animations** and hover effects
- **Responsive design** for all screen sizes
- **Modern typography** with Inter font
- **Visual feedback** for all interactions

## 🔧 Browser Compatibility

- Chrome/Chromium (recommended)
- Firefox
- Safari (partial support)
- Edge

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Support

If you encounter any issues or have suggestions, please open an issue on GitHub.

---

**Made with ❤️ for music creators everywhere!**
