// MusicMaker Pro - JavaScript Implementation
class MusicMaker {
    constructor() {
        this.audioContext = null;
        this.masterGain = null;
        this.compressor = null;
        this.reverb = null;
        this.delay = null;
        this.filter = null;
        this.distortion = null;
        
        // Synthesizer properties
        this.waveform = 'sine';
        this.volume = 0.5;
        this.attack = 0.1;
        this.release = 0.5;
        this.activeOscillators = new Map();
        
        // Beat maker properties
        this.isPlaying = false;
        this.currentStep = 0;
        this.tempo = 120;
        this.stepInterval = null;
        this.drumPatterns = [];
        
        // Recording properties
        this.isRecording = false;
        this.mediaRecorder = null;
        this.recordedChunks = [];
        this.recordedTracks = [];
        
        // Piano properties
        this.noteFrequencies = {
            'C4': 261.63, 'C#4': 277.18, 'D4': 293.66, 'D#4': 311.13,
            'E4': 329.63, 'F4': 349.23, 'F#4': 369.99, 'G4': 392.00,
            'G#4': 415.30, 'A4': 440.00, 'A#4': 466.16, 'B4': 493.88,
            'C5': 523.25, 'C#5': 554.37, 'D5': 587.33, 'D#5': 622.25,
            'E5': 659.25, 'F5': 698.46, 'F#5': 739.99, 'G5': 783.99,
            'G#5': 830.61, 'A5': 880.00, 'A#5': 932.33, 'B5': 987.77
        };
        
        this.init();
    }
    
    async init() {
        await this.initAudioContext();
        this.setupEventListeners();
        this.createPiano();
        this.createDrumGrid();
        this.setupEffects();
        this.updateDisplayValues();
    }
    
    async initAudioContext() {
        try {
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
            
            // Create master gain
            this.masterGain = this.audioContext.createGain();
            this.masterGain.gain.value = 0.7;
            
            // Create compressor
            this.compressor = this.audioContext.createDynamicsCompressor();
            this.compressor.threshold.setValueAtTime(-24, this.audioContext.currentTime);
            this.compressor.knee.setValueAtTime(30, this.audioContext.currentTime);
            this.compressor.ratio.setValueAtTime(12, this.audioContext.currentTime);
            this.compressor.attack.setValueAtTime(0.003, this.audioContext.currentTime);
            this.compressor.release.setValueAtTime(0.25, this.audioContext.currentTime);
            
            // Connect audio chain
            this.masterGain.connect(this.compressor);
            this.compressor.connect(this.audioContext.destination);
            
        } catch (error) {
            console.error('Failed to initialize audio context:', error);
        }
    }
    
    setupEventListeners() {
        // Header controls
        document.getElementById('playBtn').addEventListener('click', () => this.togglePlayback());
        document.getElementById('stopBtn').addEventListener('click', () => this.stopPlayback());
        document.getElementById('recordBtn').addEventListener('click', () => this.toggleRecording());
        
        // Tempo control
        const tempoSlider = document.getElementById('tempoSlider');
        tempoSlider.addEventListener('input', (e) => {
            this.tempo = parseInt(e.target.value);
            document.getElementById('tempoValue').textContent = this.tempo;
        });
        
        // Synthesizer controls
        document.getElementById('waveform').addEventListener('change', (e) => {
            this.waveform = e.target.value;
        });
        
        document.getElementById('volume').addEventListener('input', (e) => {
            this.volume = parseFloat(e.target.value);
            document.getElementById('volumeValue').textContent = Math.round(this.volume * 100) + '%';
        });
        
        document.getElementById('attack').addEventListener('input', (e) => {
            this.attack = parseFloat(e.target.value);
            document.getElementById('attackValue').textContent = this.attack + 's';
        });
        
        document.getElementById('release').addEventListener('input', (e) => {
            this.release = parseFloat(e.target.value);
            document.getElementById('releaseValue').textContent = this.release + 's';
        });
        
        // Effects controls
        this.setupEffectControls();
        
        // Keyboard controls
        document.addEventListener('keydown', (e) => this.handleKeyDown(e));
        document.addEventListener('keyup', (e) => this.handleKeyUp(e));
    }
    
    setupEffectControls() {
        // Reverb
        document.getElementById('reverb').addEventListener('input', (e) => {
            const value = parseFloat(e.target.value);
            document.getElementById('reverbValue').textContent = Math.round(value * 100) + '%';
            this.setReverbAmount(value);
        });
        
        // Delay
        document.getElementById('delay').addEventListener('input', (e) => {
            const value = parseFloat(e.target.value);
            document.getElementById('delayValue').textContent = Math.round(value * 100) + '%';
            this.setDelayAmount(value);
        });
        
        // Distortion
        document.getElementById('distortion').addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            document.getElementById('distortionValue').textContent = value;
            this.setDistortionAmount(value);
        });
        
        // Filter
        document.getElementById('filter').addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            document.getElementById('filterValue').textContent = value + 'Hz';
            this.setFilterCutoff(value);
        });
    }
    
    updateDisplayValues() {
        document.getElementById('tempoValue').textContent = this.tempo;
        document.getElementById('volumeValue').textContent = Math.round(this.volume * 100) + '%';
        document.getElementById('attackValue').textContent = this.attack + 's';
        document.getElementById('releaseValue').textContent = this.release + 's';
        document.getElementById('reverbValue').textContent = '0%';
        document.getElementById('delayValue').textContent = '0%';
        document.getElementById('distortionValue').textContent = '0';
        document.getElementById('filterValue').textContent = '8000Hz';
    }
    
    createPiano() {
        const piano = document.getElementById('piano');
        const whiteKeys = ['C4', 'D4', 'E4', 'F4', 'G4', 'A4', 'B4', 'C5', 'D5', 'E5', 'F5', 'G5', 'A5', 'B5'];
        const blackKeys = ['C#4', 'D#4', 'F#4', 'G#4', 'A#4', 'C#5', 'D#5', 'F#5', 'G#5', 'A#5'];
        
        // Create white keys
        whiteKeys.forEach((note, index) => {
            const key = document.createElement('div');
            key.className = 'key white';
            key.dataset.note = note;
            key.textContent = note;
            key.addEventListener('mousedown', () => this.playNote(note));
            key.addEventListener('mouseup', () => this.stopNote(note));
            key.addEventListener('mouseleave', () => this.stopNote(note));
            piano.appendChild(key);
        });
        
        // Create black keys
        const blackKeyPositions = [0.5, 1.5, 3.5, 4.5, 5.5, 7.5, 8.5, 10.5, 11.5, 12.5];
        blackKeys.forEach((note, index) => {
            const key = document.createElement('div');
            key.className = 'key black';
            key.dataset.note = note;
            key.textContent = note;
            key.style.left = `${blackKeyPositions[index] * 40 + 28}px`;
            key.style.position = 'absolute';
            key.addEventListener('mousedown', () => this.playNote(note));
            key.addEventListener('mouseup', () => this.stopNote(note));
            key.addEventListener('mouseleave', () => this.stopNote(note));
            piano.appendChild(key);
        });
    }
    
    createDrumGrid() {
        const drumTracks = document.getElementById('drumTracks');
        const trackNames = ['kick', 'snare', 'hihat', 'openhat', 'crash'];
        
        trackNames.forEach((trackName, trackIndex) => {
            const track = document.createElement('div');
            track.className = 'drum-track';
            track.dataset.track = trackName;
            
            const pattern = [];
            
            for (let step = 0; step < 16; step++) {
                const stepElement = document.createElement('div');
                stepElement.className = 'step';
                stepElement.dataset.step = step;
                stepElement.dataset.track = trackName;
                stepElement.addEventListener('click', () => this.toggleStep(trackName, step));
                track.appendChild(stepElement);
                pattern.push(false);
            }
            
            this.drumPatterns[trackIndex] = { name: trackName, pattern: pattern };
            drumTracks.appendChild(track);
        });
    }
    
    setupEffects() {
        // Create reverb
        this.reverb = this.audioContext.createConvolver();
        this.createReverbImpulse();
        
        // Create delay
        this.delay = this.audioContext.createDelay();
        this.delay.delayTime.value = 0.3;
        
        // Create filter
        this.filter = this.audioContext.createBiquadFilter();
        this.filter.type = 'lowpass';
        this.filter.frequency.value = 8000;
        this.filter.Q.value = 1;
        
        // Create distortion
        this.distortion = this.audioContext.createWaveShaper();
        this.distortion.curve = this.makeDistortionCurve(0);
        this.distortion.oversample = '4x';
    }
    
    createReverbImpulse() {
        const length = this.audioContext.sampleRate * 2;
        const impulse = this.audioContext.createBuffer(2, length, this.audioContext.sampleRate);
        
        for (let channel = 0; channel < 2; channel++) {
            const channelData = impulse.getChannelData(channel);
            for (let i = 0; i < length; i++) {
                channelData[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / length, 2);
            }
        }
        
        this.reverb.buffer = impulse;
    }
    
    makeDistortionCurve(amount) {
        const samples = 44100;
        const curve = new Float32Array(samples);
        const deg = Math.PI / 180;
        
        for (let i = 0; i < samples; i++) {
            const x = (i * 2) / samples - 1;
            curve[i] = ((3 + amount) * x * 20 * deg) / (Math.PI + amount * Math.abs(x));
        }
        
        return curve;
    }
    
    playNote(note) {
        if (!this.audioContext || this.activeOscillators.has(note)) return;
        
        const frequency = this.noteFrequencies[note];
        if (!frequency) return;
        
        const oscillator = this.audioContext.createOscillator();
        const gainNode = this.audioContext.createGain();
        
        oscillator.type = this.waveform;
        oscillator.frequency.setValueAtTime(frequency, this.audioContext.currentTime);
        
        gainNode.gain.setValueAtTime(0, this.audioContext.currentTime);
        gainNode.gain.linearRampToValueAtTime(this.volume, this.audioContext.currentTime + this.attack);
        
        oscillator.connect(gainNode);
        gainNode.connect(this.filter);
        this.filter.connect(this.distortion);
        this.distortion.connect(this.masterGain);
        
        oscillator.start(this.audioContext.currentTime);
        
        this.activeOscillators.set(note, { oscillator, gainNode });
        
        // Visual feedback
        const keyElement = document.querySelector(`[data-note="${note}"]`);
        if (keyElement) {
            keyElement.classList.add('active');
        }
    }
    
    stopNote(note) {
        const oscillatorData = this.activeOscillators.get(note);
        if (!oscillatorData) return;
        
        const { oscillator, gainNode } = oscillatorData;
        const now = this.audioContext.currentTime;
        
        gainNode.gain.cancelScheduledValues(now);
        gainNode.gain.setValueAtTime(gainNode.gain.value, now);
        gainNode.gain.linearRampToValueAtTime(0, now + this.release);
        
        oscillator.stop(now + this.release);
        this.activeOscillators.delete(note);
        
        // Visual feedback
        const keyElement = document.querySelector(`[data-note="${note}"]`);
        if (keyElement) {
            keyElement.classList.remove('active');
        }
    }
    
    toggleStep(track, step) {
        const trackIndex = this.drumPatterns.findIndex(p => p.name === track);
        if (trackIndex === -1) return;
        
        this.drumPatterns[trackIndex].pattern[step] = !this.drumPatterns[trackIndex].pattern[step];
        
        const stepElement = document.querySelector(`[data-track="${track}"][data-step="${step}"]`);
        if (stepElement) {
            stepElement.classList.toggle('active');
        }
    }
    
    playDrumSound(track) {
        if (!this.audioContext) return;
        
        const oscillator = this.audioContext.createOscillator();
        const gainNode = this.audioContext.createGain();
        const noiseBuffer = this.createNoiseBuffer();
        const noiseSource = this.audioContext.createBufferSource();
        
        // Different drum sounds
        switch (track) {
            case 'kick':
                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(60, this.audioContext.currentTime);
                oscillator.frequency.exponentialRampToValueAtTime(0.1, this.audioContext.currentTime + 0.5);
                gainNode.gain.setValueAtTime(0.8, this.audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.5);
                oscillator.connect(gainNode);
                break;
                
            case 'snare':
                noiseSource.buffer = noiseBuffer;
                gainNode.gain.setValueAtTime(0.3, this.audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.2);
                noiseSource.connect(gainNode);
                noiseSource.start(this.audioContext.currentTime);
                noiseSource.stop(this.audioContext.currentTime + 0.2);
                break;
                
            case 'hihat':
                noiseSource.buffer = noiseBuffer;
                const hihatFilter = this.audioContext.createBiquadFilter();
                hihatFilter.type = 'highpass';
                hihatFilter.frequency.value = 7000;
                gainNode.gain.setValueAtTime(0.2, this.audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.1);
                noiseSource.connect(hihatFilter);
                hihatFilter.connect(gainNode);
                noiseSource.start(this.audioContext.currentTime);
                noiseSource.stop(this.audioContext.currentTime + 0.1);
                break;
                
            case 'openhat':
                noiseSource.buffer = noiseBuffer;
                const openhatFilter = this.audioContext.createBiquadFilter();
                openhatFilter.type = 'highpass';
                openhatFilter.frequency.value = 5000;
                gainNode.gain.setValueAtTime(0.15, this.audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.3);
                noiseSource.connect(openhatFilter);
                openhatFilter.connect(gainNode);
                noiseSource.start(this.audioContext.currentTime);
                noiseSource.stop(this.audioContext.currentTime + 0.3);
                break;
                
            case 'crash':
                noiseSource.buffer = noiseBuffer;
                const crashFilter = this.audioContext.createBiquadFilter();
                crashFilter.type = 'bandpass';
                crashFilter.frequency.value = 3000;
                gainNode.gain.setValueAtTime(0.4, this.audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 1.0);
                noiseSource.connect(crashFilter);
                crashFilter.connect(gainNode);
                noiseSource.start(this.audioContext.currentTime);
                noiseSource.stop(this.audioContext.currentTime + 1.0);
                break;
        }
        
        if (track === 'kick') {
            gainNode.connect(this.masterGain);
            oscillator.start(this.audioContext.currentTime);
            oscillator.stop(this.audioContext.currentTime + 0.5);
        } else {
            gainNode.connect(this.masterGain);
        }
    }
    
    createNoiseBuffer() {
        const bufferSize = this.audioContext.sampleRate * 0.5;
        const buffer = this.audioContext.createBuffer(1, bufferSize, this.audioContext.sampleRate);
        const output = buffer.getChannelData(0);
        
        for (let i = 0; i < bufferSize; i++) {
            output[i] = Math.random() * 2 - 1;
        }
        
        return buffer;
    }
    
    togglePlayback() {
        if (!this.audioContext) return;
        
        if (this.audioContext.state === 'suspended') {
            this.audioContext.resume();
        }
        
        if (this.isPlaying) {
            this.stopPlayback();
        } else {
            this.startPlayback();
        }
    }
    
    startPlayback() {
        this.isPlaying = true;
        this.currentStep = 0;
        
        const playBtn = document.getElementById('playBtn');
        playBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
        
        const stepTime = 60000 / (this.tempo * 4); // 16th notes
        
        this.stepInterval = setInterval(() => {
            this.playStep();
            this.currentStep = (this.currentStep + 1) % 16;
        }, stepTime);
    }
    
    stopPlayback() {
        this.isPlaying = false;
        this.currentStep = 0;
        
        if (this.stepInterval) {
            clearInterval(this.stepInterval);
            this.stepInterval = null;
        }
        
        const playBtn = document.getElementById('playBtn');
        playBtn.innerHTML = '<i class="fas fa-play"></i> Play';
        
        // Remove visual indicators
        document.querySelectorAll('.step.playing').forEach(step => {
            step.classList.remove('playing');
        });
    }
    
    playStep() {
        // Remove previous step highlights
        document.querySelectorAll('.step.playing').forEach(step => {
            step.classList.remove('playing');
        });
        
        // Check each track for active steps
        this.drumPatterns.forEach(pattern => {
            if (pattern.pattern[this.currentStep]) {
                this.playDrumSound(pattern.name);
                
                // Visual feedback
                const stepElement = document.querySelector(`[data-track="${pattern.name}"][data-step="${this.currentStep}"]`);
                if (stepElement) {
                    stepElement.classList.add('playing');
                }
            }
        });
    }
    
    async toggleRecording() {
        if (!this.isRecording) {
            await this.startRecording();
        } else {
            this.stopRecording();
        }
    }
    
    async startRecording() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                audio: {
                    echoCancellation: false,
                    noiseSuppression: false,
                    sampleRate: 44100
                }
            });
            
            this.mediaRecorder = new MediaRecorder(stream, {
                mimeType: 'audio/webm;codecs=opus'
            });
            
            this.recordedChunks = [];
            
            this.mediaRecorder.ondataavailable = (event) => {
                if (event.data.size > 0) {
                    this.recordedChunks.push(event.data);
                }
            };
            
            this.mediaRecorder.onstop = () => {
                this.saveRecording();
            };
            
            this.mediaRecorder.start();
            this.isRecording = true;
            
            // Update UI
            const recordBtn = document.getElementById('recordBtn');
            recordBtn.classList.add('recording');
            recordBtn.innerHTML = '<i class="fas fa-stop"></i> Stop Recording';
            
            const indicator = document.getElementById('recordingIndicator');
            indicator.classList.add('recording');
            
            document.getElementById('recordingStatus').textContent = 'Recording...';
            
        } catch (error) {
            console.error('Failed to start recording:', error);
            alert('Failed to access microphone. Please check permissions.');
        }
    }
    
    stopRecording() {
        if (this.mediaRecorder && this.isRecording) {
            this.mediaRecorder.stop();
            this.isRecording = false;
            
            // Update UI
            const recordBtn = document.getElementById('recordBtn');
            recordBtn.classList.remove('recording');
            recordBtn.innerHTML = '<i class="fas fa-circle"></i> Record';
            
            const indicator = document.getElementById('recordingIndicator');
            indicator.classList.remove('recording');
            
            document.getElementById('recordingStatus').textContent = 'Recording saved';
            
            // Stop all tracks
            if (this.mediaRecorder.stream) {
                this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
            }
        }
    }
    
    saveRecording() {
        const blob = new Blob(this.recordedChunks, { type: 'audio/webm' });
        const url = URL.createObjectURL(blob);
        const timestamp = new Date().toLocaleTimeString();
        
        const track = {
            id: Date.now(),
            name: `Recording ${timestamp}`,
            url: url,
            blob: blob
        };
        
        this.recordedTracks.push(track);
        this.displayRecordedTrack(track);
    }
    
    displayRecordedTrack(track) {
        const container = document.getElementById('recordedTracks');
        
        const trackElement = document.createElement('div');
        trackElement.className = 'recorded-track';
        trackElement.innerHTML = `
            <div class="track-info">
                <i class="fas fa-music"></i>
                <span>${track.name}</span>
            </div>
            <div class="track-controls">
                <button class="btn btn-primary" onclick="musicMaker.playRecording('${track.id}')">
                    <i class="fas fa-play"></i> Play
                </button>
                <button class="btn btn-secondary" onclick="musicMaker.downloadRecording('${track.id}')">
                    <i class="fas fa-download"></i> Download
                </button>
                <button class="btn btn-danger" onclick="musicMaker.deleteRecording('${track.id}')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        `;
        
        container.appendChild(trackElement);
    }
    
    playRecording(trackId) {
        const track = this.recordedTracks.find(t => t.id == trackId);
        if (track) {
            const audio = new Audio(track.url);
            audio.play();
        }
    }
    
    downloadRecording(trackId) {
        const track = this.recordedTracks.find(t => t.id == trackId);
        if (track) {
            const a = document.createElement('a');
            a.href = track.url;
            a.download = `${track.name}.webm`;
            a.click();
        }
    }
    
    deleteRecording(trackId) {
        const trackIndex = this.recordedTracks.findIndex(t => t.id == trackId);
        if (trackIndex !== -1) {
            URL.revokeObjectURL(this.recordedTracks[trackIndex].url);
            this.recordedTracks.splice(trackIndex, 1);
            
            // Remove from DOM
            const trackElement = document.querySelector(`[onclick="musicMaker.deleteRecording('${trackId}')"]`).closest('.recorded-track');
            if (trackElement) {
                trackElement.remove();
            }
        }
    }
    
    // Effect methods
    setReverbAmount(amount) {
        // Implementation would involve wet/dry mix control
    }
    
    setDelayAmount(amount) {
        if (this.delay) {
            // Implementation would involve wet/dry mix control
        }
    }
    
    setDistortionAmount(amount) {
        if (this.distortion) {
            this.distortion.curve = this.makeDistortionCurve(amount);
        }
    }
    
    setFilterCutoff(frequency) {
        if (this.filter) {
            this.filter.frequency.setValueAtTime(frequency, this.audioContext.currentTime);
        }
    }
    
    // Keyboard handling
    handleKeyDown(e) {
        const keyMap = {
            'a': 'C4', 'w': 'C#4', 's': 'D4', 'e': 'D#4', 'd': 'E4',
            'f': 'F4', 't': 'F#4', 'g': 'G4', 'y': 'G#4', 'h': 'A4',
            'u': 'A#4', 'j': 'B4', 'k': 'C5', 'o': 'C#5', 'l': 'D5'
        };
        
        const note = keyMap[e.key.toLowerCase()];
        if (note && !e.repeat) {
            this.playNote(note);
        }
        
        // Spacebar for play/pause
        if (e.code === 'Space') {
            e.preventDefault();
            this.togglePlayback();
        }
    }
    
    handleKeyUp(e) {
        const keyMap = {
            'a': 'C4', 'w': 'C#4', 's': 'D4', 'e': 'D#4', 'd': 'E4',
            'f': 'F4', 't': 'F#4', 'g': 'G4', 'y': 'G#4', 'h': 'A4',
            'u': 'A#4', 'j': 'B4', 'k': 'C5', 'o': 'C#5', 'l': 'D5'
        };
        
        const note = keyMap[e.key.toLowerCase()];
        if (note) {
            this.stopNote(note);
        }
    }
}

// Initialize the music maker when the page loads
let musicMaker;

document.addEventListener('DOMContentLoaded', () => {
    musicMaker = new MusicMaker();
});

// Expose some functions globally for HTML onclick handlers
window.musicMaker = musicMaker;