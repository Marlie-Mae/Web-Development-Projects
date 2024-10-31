if (document.querySelector(".gallery__item")) {

	const container = document.querySelector(".container");

	const galleryItem = document.querySelectorAll(".gallery__item");

	const cleaner = () => {

		galleryItem.forEach((gallery) => {

			gallery.classList.remove("--active");

		});

	};

	galleryItem.forEach((gallery, i) => {

		gallery.addEventListener("click", () => {

			cleaner();

			gallery.classList.add("--active");

			if (i === 0) {

				container.style.backgroundColor = "#e7ac7d";

			}

			if (i === 1) {

				container.style.backgroundColor = "#965a3b";

			}

			if (i === 2) {

				container.style.backgroundColor = "#bc9a15";

			}

			if (i === 3) {

				container.style.backgroundColor = "#d1ac3e";

			}

			if (i === 4) {

				container.style.backgroundColor = "#8a8088";

			}

			if (i === 5) {

				container.style.backgroundColor = "#d54415";

			}

			if (i === 6) {

				container.style.backgroundColor = "#f47900";

			}

			if (i === 7) {

				container.style.backgroundColor = "#081c4e";

			}

		});

	});

}