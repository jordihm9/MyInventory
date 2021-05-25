'use strict';

let element = $('#hero-text');

const sentences = [
	'Manage your belongings'
];

carousel();

async function typeSentence(sentence, delay = 100) {
	const letters = sentence.split("");
	let i = 0;
	while(i < letters.length) {
	  await waitForMs(delay);
	  element.append(letters[i]);
	  i++
	}
	return;
}

async function deleteSentence() {
	const sentence = $(element).html();
	const letters = sentence.split("");
	let i = 0;
	while(letters.length > 0) {
	  await waitForMs(100);
	  letters.pop();
	  $(element).html(letters.join(""));
	}
}

async function carousel() {
    var i = 0;
    while (true) {
      await typeSentence(sentences[i]);
      await waitForMs(1500);
      await deleteSentence();
      await waitForMs(500);
      i++
      if (i >= sentences.length) {i = 0;}
    }
}

function waitForMs(ms) {
	return new Promise(resolve => setTimeout(resolve, ms))
}