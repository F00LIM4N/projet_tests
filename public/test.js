const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto('http://127.0.0.1:8000');

    const title = await page.title();
    console.assert(title === 'Accueil morpion', 'Title is incorrect');

    const h1Text = await page.$eval('h1.text-center', el => el.textContent);
    console.assert(h1Text === 'Bienvenue au Jeu du Morpion', 'H1 text is incorrect');

    const pText = await page.$eval('p.text-center', el => el.textContent);
    console.assert(pText.includes('Le jeu du morpion (ou tic-tac-toe)'), 'Paragraph text is incorrect');

    const table = await page.$('table.table-bordered');
    console.assert(table !== null, 'Game table is not found');

    const gameNameInput = await page.$('input#gameName');
    console.assert(gameNameInput !== null, 'Game name input is not found');

    const contactForm = await page.$('form');
    console.assert(contactForm !== null, 'Contact form is not found');

    await page.type('#gameName', 'Alice');
    const submitButtonDisabled = await page.$eval('button[type="submit"]', btn => btn.disabled);
    console.assert(submitButtonDisabled === true, 'Submit button should be disabled for name "Alice"');

    await page.evaluate(() => document.getElementById('gameName').value = '');
    await page.type('#gameName', 'Dave');
    const submitButtonEnabled = await page.$eval('button[type="submit"]', btn => !btn.disabled);
    console.assert(submitButtonEnabled === true, 'Submit button should be enabled for name "Dave"');

    await browser.close();
})();