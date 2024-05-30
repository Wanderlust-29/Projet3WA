// article.test.js
const { JSDOM } = require('jsdom');
const {initArticlePage, burgerMenu, gradeStar, animationCart } = require('./article');

let dom;
let document;

beforeEach(() => {
  dom = new JSDOM(`
    <body>
      <div class="section-adopt"></div>
      <button class="btn-description"></button>
      <button class="btn-ingredients"></button>
      <div class="description" style="display: none;"></div>
      <div class="ingredients" style="display: none;"></div>
      <div class="grade">4</div>
      <div class="average-grade">3</div>
      <button class="cart-button"></button>
    </body>
  `);
  document = dom.window.document;
  global.document = document;
  global.window = dom.window;
});

describe('burgerMenu', () => {
  test('toggles description and ingredients visibility on button clicks', () => {
    burgerMenu();

    const btnDescription = document.querySelector('.btn-description');
    const btnIngredients = document.querySelector('.btn-ingredients');
    const description = document.querySelector('.description');
    const ingredients = document.querySelector('.ingredients');

    btnDescription.click();
    expect(description.style.display).toBe('block');
    expect(ingredients.style.display).toBe('none');

    btnIngredients.click();
    expect(description.style.display).toBe('none');
    expect(ingredients.style.display).toBe('block');
  });
});

describe('gradeStar', () => {
  test('displays stars correctly based on grades', () => {
    gradeStar();

    const grades = document.querySelectorAll('.grade');
    const averageGrade = document.querySelector('.average-grade');

    expect(grades[0].innerText).toBe('⭐⭐⭐⭐ ');
    expect(averageGrade.innerText).toBe('⭐⭐⭐ (1)');
  });
});

describe('animationCart', () => {
  test('adds and removes "clicked" class on cart button click', () => {
    jest.useFakeTimers();
    initArticlePage();
    animationCart();

    const cartButton = document.querySelector('.cart-button');
    cartButton.click();

    expect(cartButton.classList.contains('clicked')).toBe(true);
    
    jest.advanceTimersByTime(3000);
    expect(cartButton.classList.contains('clicked')).toBe(false);
  });
});