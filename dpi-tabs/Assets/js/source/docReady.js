export default function docReady(...fnx) {
    const fire = () => fnx.forEach(fn => fn());

    if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
        fire();    
    } else {
        document.addEventListener('DOMContentLoaded', fire);
    }
}