const input = document.querySelector('input');
const titles = document.querySelectorAll('h1');

input.addEventListener('keyup', e => {
	titles.forEach(title => {
		if (title.textContent.toLowerCase().includes(e.target.value.toLowerCase())) {
			title.parentNode.style.display = 'block';
		}else{
			title.parentNode.style.display = 'none'
		}
	})
})