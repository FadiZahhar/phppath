(function () {
    var audio, isWebkit, oscillator, gainNode;

    // Create audio context
    if (window.AudioContext) {
        audio = new AudioContext();
    } else if (window.webkitAudioContext) {
        audio = new webkitAudioContext();
        isWebkit = true;
    } else {
        return false;
    }

    // Event handlers
    document.addEventListener('mousedown', startTone, false);
    document.addEventListener('mouseup', stopTone, false);

    function startTone() {
        // Create oscillator and gain node
        oscillator = audio.createOscillator();
        if (!isWebkit) {
            gainNode = audio.createGain();
        } else {
            gainNode = audio.createGainNode();
        }

        // Set waveform
        oscillator.type = 'triangle';

        // Link audio chain
        oscillator.connect(gainNode);
        gainNode.connect(audio.destination);
        oscillator.start();
    }

    function stopTone() {
        oscillator.stop();
    }
})();