const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto('http://127.0.0.1:8000');
    const title = await page.title();

    console.assert(title === 'Hello TestController!', 'Title is incorrect');

    await browser.close();
})();