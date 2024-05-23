const video = document.querySelector(".about-hike__video")
const button = document.querySelector(".video-wrapper")

let videoState = "paused"

button.addEventListener("click", () => {
    if(videoState === "paused") {
        video.play()
        videoState = "playing"
        button.classList.add("active")
    } else {
        video.pause()
        videoState = "paused"
        button.classList.remove("active")
    }
})