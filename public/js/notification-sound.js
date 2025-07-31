// Notification Sound Generator
class NotificationSound {
    constructor() {
        this.audioContext = null;
        this.initAudioContext();
    }

    initAudioContext() {
        try {
            // Coba buat AudioContext
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        } catch (e) {
            console.log('Web Audio API tidak didukung');
        }
    }

    // Generate suara notifikasi sederhana
    playNotificationSound() {
        if (!this.audioContext) {
            this.initAudioContext();
        }

        if (!this.audioContext) {
            // Fallback ke audio HTML5 sederhana
            this.playFallbackSound();
            return;
        }

        try {
            // Buat oscillator untuk menghasilkan suara
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();

            // Hubungkan nodes
            oscillator.connect(gainNode);
            gainNode.connect(this.audioContext.destination);

            // Set properti suara
            oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime); // Frekuensi 800Hz
            oscillator.frequency.setValueAtTime(600, this.audioContext.currentTime + 0.1); // Turun ke 600Hz
            oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime + 0.2); // Naik lagi ke 800Hz

            // Set volume
            gainNode.gain.setValueAtTime(0.3, this.audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.3);

            // Set tipe gelombang
            oscillator.type = 'sine';

            // Mainkan suara
            oscillator.start(this.audioContext.currentTime);
            oscillator.stop(this.audioContext.currentTime + 0.3);

        } catch (e) {
            console.log('Error playing notification sound:', e);
            this.playFallbackSound();
        }
    }

    // Fallback menggunakan HTML5 Audio
    playFallbackSound() {
        try {
            // Buat audio element dengan data URI sederhana
            const audio = new Audio();
            
            // Generate suara beep sederhana menggunakan data URI
            const sampleRate = 44100;
            const duration = 0.3; // 300ms
            const frequency = 800;
            
            // Buat array untuk audio data
            const samples = Math.floor(sampleRate * duration);
            const audioData = new Float32Array(samples);
            
            for (let i = 0; i < samples; i++) {
                const t = i / sampleRate;
                audioData[i] = Math.sin(2 * Math.PI * frequency * t) * 0.3;
            }
            
            // Convert ke WAV format sederhana
            const wavData = this.float32ToWav(audioData, sampleRate);
            const blob = new Blob([wavData], { type: 'audio/wav' });
            const url = URL.createObjectURL(blob);
            
            audio.src = url;
            audio.volume = 0.3;
            audio.play().then(() => {
                // Cleanup setelah selesai
                setTimeout(() => {
                    URL.revokeObjectURL(url);
                }, 1000);
            }).catch(e => {
                console.log('Audio play failed:', e);
                URL.revokeObjectURL(url);
            });
            
        } catch (e) {
            console.log('Fallback audio failed:', e);
        }
    }

    // Convert Float32Array ke WAV format
    float32ToWav(float32Array, sampleRate) {
        const buffer = new ArrayBuffer(44 + float32Array.length * 2);
        const view = new DataView(buffer);
        
        // WAV header
        const writeString = (offset, string) => {
            for (let i = 0; i < string.length; i++) {
                view.setUint8(offset + i, string.charCodeAt(i));
            }
        };
        
        writeString(0, 'RIFF');
        view.setUint32(4, 36 + float32Array.length * 2, true);
        writeString(8, 'WAVE');
        writeString(12, 'fmt ');
        view.setUint32(16, 16, true);
        view.setUint16(20, 1, true);
        view.setUint16(22, 1, true);
        view.setUint32(24, sampleRate, true);
        view.setUint32(28, sampleRate * 2, true);
        view.setUint16(32, 2, true);
        view.setUint16(34, 16, true);
        writeString(36, 'data');
        view.setUint32(40, float32Array.length * 2, true);
        
        // Convert float32 ke int16
        let offset = 44;
        for (let i = 0; i < float32Array.length; i++) {
            const sample = Math.max(-1, Math.min(1, float32Array[i]));
            view.setInt16(offset, sample < 0 ? sample * 0x8000 : sample * 0x7FFF, true);
            offset += 2;
        }
        
        return buffer;
    }

    // Suara notifikasi yang berbeda untuk tipe notifikasi berbeda
    playCustomSound(type = 'default') {
        switch (type) {
            case 'pemilih_baru':
                this.playPemilihSound();
                break;
            case 'caleg_baru':
                this.playCalegSound();
                break;
            case 'kegiatan_baru':
                this.playKegiatanSound();
                break;
            case 'urgent':
                this.playUrgentSound();
                break;
            default:
                this.playNotificationSound();
        }
    }

    // Suara khusus untuk pemilih baru (2 beep)
    playPemilihSound() {
        if (!this.audioContext) {
            this.initAudioContext();
        }

        if (!this.audioContext) {
            this.playFallbackSound();
            return;
        }

        try {
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(this.audioContext.destination);

            // 2 beep pendek
            oscillator.frequency.setValueAtTime(600, this.audioContext.currentTime);
            oscillator.frequency.setValueAtTime(600, this.audioContext.currentTime + 0.1);
            oscillator.frequency.setValueAtTime(0, this.audioContext.currentTime + 0.15);
            oscillator.frequency.setValueAtTime(600, this.audioContext.currentTime + 0.25);
            oscillator.frequency.setValueAtTime(600, this.audioContext.currentTime + 0.35);

            gainNode.gain.setValueAtTime(0.3, this.audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.4);

            oscillator.type = 'sine';
            oscillator.start(this.audioContext.currentTime);
            oscillator.stop(this.audioContext.currentTime + 0.4);

        } catch (e) {
            this.playFallbackSound();
        }
    }

    // Suara khusus untuk caleg baru (3 beep)
    playCalegSound() {
        if (!this.audioContext) {
            this.initAudioContext();
        }

        if (!this.audioContext) {
            this.playFallbackSound();
            return;
        }

        try {
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(this.audioContext.destination);

            // 3 beep pendek
            oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime);
            oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime + 0.08);
            oscillator.frequency.setValueAtTime(0, this.audioContext.currentTime + 0.12);
            oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime + 0.2);
            oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime + 0.28);
            oscillator.frequency.setValueAtTime(0, this.audioContext.currentTime + 0.32);
            oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime + 0.4);
            oscillator.frequency.setValueAtTime(800, this.audioContext.currentTime + 0.48);

            gainNode.gain.setValueAtTime(0.3, this.audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.55);

            oscillator.type = 'sine';
            oscillator.start(this.audioContext.currentTime);
            oscillator.stop(this.audioContext.currentTime + 0.55);

        } catch (e) {
            this.playFallbackSound();
        }
    }

    // Suara khusus untuk kegiatan baru (melodi naik)
    playKegiatanSound() {
        if (!this.audioContext) {
            this.initAudioContext();
        }

        if (!this.audioContext) {
            this.playFallbackSound();
            return;
        }

        try {
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(this.audioContext.destination);

            // Melodi naik
            oscillator.frequency.setValueAtTime(400, this.audioContext.currentTime);
            oscillator.frequency.setValueAtTime(500, this.audioContext.currentTime + 0.1);
            oscillator.frequency.setValueAtTime(600, this.audioContext.currentTime + 0.2);
            oscillator.frequency.setValueAtTime(700, this.audioContext.currentTime + 0.3);

            gainNode.gain.setValueAtTime(0.3, this.audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.4);

            oscillator.type = 'sine';
            oscillator.start(this.audioContext.currentTime);
            oscillator.stop(this.audioContext.currentTime + 0.4);

        } catch (e) {
            this.playFallbackSound();
        }
    }

    // Suara urgent (beep panjang)
    playUrgentSound() {
        if (!this.audioContext) {
            this.initAudioContext();
        }

        if (!this.audioContext) {
            this.playFallbackSound();
            return;
        }

        try {
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(this.audioContext.destination);

            // Beep panjang
            oscillator.frequency.setValueAtTime(1000, this.audioContext.currentTime);
            oscillator.frequency.setValueAtTime(1000, this.audioContext.currentTime + 0.5);

            gainNode.gain.setValueAtTime(0.4, this.audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.5);

            oscillator.type = 'sine';
            oscillator.start(this.audioContext.currentTime);
            oscillator.stop(this.audioContext.currentTime + 0.5);

        } catch (e) {
            this.playFallbackSound();
        }
    }
}

// Export untuk penggunaan global
window.NotificationSound = NotificationSound; 