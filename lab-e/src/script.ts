const msg: string = "Hello!";

alert(msg);

const styles = [
    { name: "Style 1", file: "/style.1.css" },
    { name: "Style 2", file: "/style.2.css" },
    { name: "Style 3", file: "/style.3.css" }
];

let currentLink: HTMLLinkElement | null = null;

function loadStyle(file: string) {
    if (currentLink) {
        currentLink.remove();
    }

    currentLink = document.createElement("link");
    currentLink.rel = "stylesheet";
    currentLink.href = file;

    document.head.appendChild(currentLink);
}

function createButtons() {
    const container = document.createElement("div");

    styles.forEach((style) => {
        const button = document.createElement("button");

        button.textContent = style.name;

        button.onclick = () => {
            loadStyle(style.file);
        };

        container.appendChild(button);
    });

    document.body.prepend(container);
}

loadStyle(styles[0].file);
createButtons();