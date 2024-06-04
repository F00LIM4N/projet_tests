function checkGameName() {
    console.log("ahah");
    const gameNameInput = document.getElementById("gameName");
    const inputValue = gameNameInput.value;

    if (inputValue === "Alice" || inputValue === "Bob" || inputValue === "Charlie") {
        document.querySelector("button[type='submit']").disabled = true;
    } else {
        document.querySelector("button[type='submit']").disabled = false;
    }
}

document.getElementById("gameName").addEventListener("input", checkGameName);
