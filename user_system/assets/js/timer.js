document.addEventListener('DOMContentLoaded', function() {
    const minutesDisplay = document.getElementById('minutes');
    const secondsDisplay = document.getElementById('seconds');
    const startBtn = document.getElementById('startTimer');
    const pauseBtn = document.getElementById('pauseTimer');
    const resetBtn = document.getElementById('resetTimer');
    const completedSessions = document.getElementById('completedSessions');
    const totalTime = document.getElementById('totalTime');
    
    let timeLeft = 45 * 60; // 45 دقيقة بالثواني
    let timerInterval;
    let isRunning = false;
    let sessionsCompleted = 0;
    let totalSeconds = 0;
    
    function updateDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        minutesDisplay.textContent = minutes.toString().padStart(2, '0');
        secondsDisplay.textContent = seconds.toString().padStart(2, '0');
    }
    
    function updateTotalTime() {
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;
        
        totalTime.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    function startTimer() {
        if (isRunning) return;
        
        isRunning = true;
        startBtn.disabled = true;
        pauseBtn.disabled = false;
        
        timerInterval = setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                totalSeconds++;
                updateDisplay();
                updateTotalTime();
            } else {
                clearInterval(timerInterval);
                sessionsCompleted++;
                completedSessions.textContent = sessionsCompleted;
                alert('انتهى وقت العمل! خذ استراحة قصيرة');
                resetTimer();
            }
        }, 1000);
    }
    
    function pauseTimer() {
        clearInterval(timerInterval);
        isRunning = false;
        startBtn.disabled = false;
        pauseBtn.disabled = true;
    }
    
    function resetTimer() {
        pauseTimer();
        timeLeft = 45 * 60;
        updateDisplay();
    }
    
    startBtn.addEventListener('click', startTimer);
    pauseBtn.addEventListener('click', pauseTimer);
    resetBtn.addEventListener('click', resetTimer);
    
    // تحديث العرض أول مرة
    updateDisplay();
    updateTotalTime();
    
    // جلب المهمة الحالية من عنوان URL
    const urlParams = new URLSearchParams(window.location.search);
    const task = urlParams.get('task');
    if (task) {
        document.getElementById('currentTaskText').textContent = decodeURIComponent(task);
    }
});