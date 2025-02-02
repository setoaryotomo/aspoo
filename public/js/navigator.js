let nextIndex = 0
let currentUrl; //string
let lastRenderedId; //string
let lastRenderedIndex; //number
let savedScrollRestoration; //ScrollRestoration
let navigatorController = new AbortController()

function initializeNavigator() {

    // initial setting
    currentUrl = location.href;
    nextIndex = 0;
    savedScrollRestoration = history.scrollRestoration;
    lastRenderedId = createUniqueId();
    lastRenderedIndex = nextIndex++;

    // initial history configuration
    history.replaceState(
        { id: lastRenderedId, index: lastRenderedIndex },
        "",
        location.href,
    );
    history.scrollRestoration = "manual";

    // listen navigation action (like back arrow or next arrow)
    addEventListener("popstate", handleNavigation);

    // intercept all link click to handle with js
    window.onload = function(){
        document.body.addEventListener("click", handleClick);
    }
}

function handleClick(e) {
    if (!shouldHandleClick(e)) return; // check is it click what we want to handle
    e.preventDefault();
    navigate(e.target.getAttribute('href'));
}

function navigate(
    to,
    options,
) {
    const url = new URL(to, location.href);
    if (url.origin !== location.origin) {
        location.href = url.href;
        return new Promise(() => { });
    }

    const { replace, scroll, data } = options || {};
    const id = createUniqueId();

    if (replace) {
        history.replaceState({ id, data, index: history.state.index }, "", to);
    } else {
        const index = nextIndex++;
        history.pushState({ id, data, index }, "", to);
    }

    return handleNavigation(undefined, scroll);
}


async function handleNavigation(_, scroll = true) {
    renderLoadingScreen(document.getElementById("root-content"))
    // Save scroll position
    const scrollPosition = { x: scrollX, y: scrollY };
    sessionStorage.setItem(
        `knave:${lastRenderedId}`,
        JSON.stringify(scrollPosition),
    );
    // Render new page
    currentUrl = location.href;
    // LOADING PAGE
    try { navigatorController.abort() } catch (err) { }
    navigatorController = new AbortController()
    const page = await httpClient.get(currentUrl, {
        signal: navigatorController.signal,
        headers: { "X-Partial-Content": true },
    });
    setInnerHTML(document.getElementById("root-content"), page.data)
    if (scroll) restoreScrollPosition();
    lastRenderedId = history.state.id;
    lastRenderedIndex = history.state.index;
}

function restoreScrollPosition() {
    const scrollPosition = sessionStorage.getItem(`knave:${history.state?.id}`);

    if (scrollPosition) {
        const { x, y } = JSON.parse(scrollPosition);
        scrollTo(x, y);
    } else {
        const hash = location.hash;
        if (hash) {
            const element = document.querySelector(hash);
            if (element) {
                element.scrollIntoView();
            }
        } else {
            scrollTo(0, 0);
        }
    }
}

// navigator tools
function shouldHandleClick(e) {
    const t = e.target
    return (
        // (t instanceof HTMLAnchorElement ||
        //     t instanceof SVGAElement ||
        //     t instanceof HTMLAreaElement) &&
        !e.defaultPrevented &&
        (t.href !== undefined || 
            t.hasAttribute('href')) &&
        !t.hasAttribute('data-toggle')
        // (!t.target || t.target !== "_self") &&
        // !t.hasAttribute("download") &&
        // !t.relList.contains("external")
    );
}
function createUniqueId() {
    return Math.random().toString(36).substr(2, 9);
}
function setInnerHTML(elm, html) {
    elm.innerHTML = html;

    Array.from(elm.querySelectorAll("script")).forEach(oldScript => {
        const newScript = document.createElement("script");
        Array.from(oldScript.attributes)
            .forEach(attr => {
                console.log(attr)
                newScript.setAttribute(attr.name, attr.value)
            });
        newScript.appendChild(document.createTextNode(oldScript.innerHTML));
        oldScript.parentNode.replaceChild(newScript, oldScript);
    });
}
function renderLoadingScreen(elm) {
    elm.innerHTML = `
    <div class="page-inner">
        <div class="card bg-opacity-50">
            <div class="card-body" style="height: 500px">
                <div class="loading">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
        </div>
    </div>
    `
}

// initialize client side navigator
initializeNavigator()

