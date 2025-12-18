document.addEventListener("DOMContentLoaded", function () {
    const currentTimeEl = document.getElementById("current-time");

    function updateCurrentTime() {
        const now = new Date();
        const hh = String(now.getHours()).padStart(2, "0");
        const mm = String(now.getMinutes()).padStart(2, "0");
        currentTimeEl.textContent = `${hh}:${mm}`;
    }

    function startMinuteSync() {
        updateCurrentTime();

        const now = new Date();
        const seconds = now.getSeconds();
        const milliseconds = now.getMilliseconds();

        // ⭐ 次の分までの残り時間
        const delay = (60 - seconds) * 1000 - milliseconds;

        setTimeout(() => {
            updateCurrentTime();

            // ⭐ 以降は正確に1分ごと
            setInterval(updateCurrentTime, 60000);
        }, delay);
    }

    startMinuteSync();
});
