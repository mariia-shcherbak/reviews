const books = [
  {
    id: 1,
    title: "To Kill a Mockingbird",
    author: "Harper Lee",
    image:
      "https://www.harpercollins.com/cdn/shop/products/9780060935467_0c4c38ab-8f1a-458a-8fde-f1655309c4c7.jpg?v=1699450588&width=350",
    description:
      "A gripping, heart-wrenching, and wholly remarkable tale of coming-of-age in a South poisoned by virulent prejudice.",
    pages: 281,
    publisher: "J. B. Lippincott & Co.",
    year: 1960,
    country: "United States",
    rating: 4.5,
  },
  {
    id: 2,
    title: "1984",
    author: "George Orwell",
    image:
      "https://www.knihydobrovsky.cz/thumbs/book-detail/mod_eshop/produkty/1/1984-9780141036144_26.jpg",
    description:
      "A dystopian novel set in a totalitarian society, exploring the consequences of government overreach, totalitarianism, and repressive regimentation of all persons and behaviors within society.",
    pages: 328,
    publisher: "Secker & Warburg",
    year: 1949,
    country: "United Kingdom",
    rating: 4.7,
  },
  {
    id: 3,
    title: "The Great Gatsby",
    author: "F. Scott Fitzgerald",
    image:
      "https://m.media-amazon.com/images/I/71V1cA2fiZL._AC_UF1000,1000_QL80_.jpg",
    description:
      "A novel of lyrical beauty and uncompromising insight into the American dream, exploring themes of decadence, idealism, resistance to change, and social upheaval.",
    pages: 218,
    publisher: "Charles Scribner's Sons",
    year: 1925,
    country: "United States",
    rating: 4.2,
  },
  {
    id: 4,
    title: "Pride and Prejudice",
    author: "Jane Austen",
    image:
      "https://s3.amazonaws.com/nightjarprod/content/uploads/sites/249/2024/04/25131246/sGjIvtVvTlWnia2zfJfHz81pZ9Q.jpg",
    description:
      "A romantic novel of manners that follows the character development of Elizabeth Bennet, dealing with issues of manners, upbringing, morality, education, and marriage in the society of the landed gentry of early 19th-century England.",
    pages: 432,
    publisher: "T. Egerton, Whitehall",
    year: 1813,
    country: "United Kingdom",
    rating: 4.6,
  },
  {
    id: 5,
    title: "The Catcher in the Rye",
    author: "J.D. Salinger",
    image:
      "https://npr.brightspotcdn.com/dims4/default/f735808/2147483647/strip/true/crop/363x574+0+0/resize/880x1392!/quality/90/?url=http%3A%2F%2Fnpr-brightspot.s3.amazonaws.com%2Flegacy%2Fsites%2Fwkar%2Ffiles%2Fcatcher_in_the_rye_cover.png",
    description:
      "A story of teenage angst and alienation, following Holden Caulfield's experiences in New York City in the days following his expulsion from prep school.",
    pages: 234,
    publisher: "Little, Brown and Company",
    year: 1951,
    country: "United States",
    rating: 4.0,
  },
  {
    id: 6,
    title: "To the Lighthouse",
    author: "Virginia Woolf",
    image: "https://almabooks.com/wp-content/uploads/2017/03/9781847496577.jpg",
    description:
      "A landmark novel of high modernism, centering on the Ramsay family and their visits to the Isle of Skye in Scotland between 1910 and 1920.",
    pages: 209,
    publisher: "Hogarth Press",
    year: 1927,
    country: "United Kingdom",
    rating: 4.1,
  },
];

let reviews = [
  {
    id: 1,
    bookId: 1,
    userId: "user1",
    username: "John Doe",
    rating: 5,
    text: "An absolute masterpiece! This book changed my perspective on life.",
  },
  {
    id: 2,
    bookId: 1,
    userId: "user2",
    username: "Jane Smith",
    rating: 4,
    text: "A powerful story that everyone should read at least once.",
  },
  {
    id: 3,
    bookId: 2,
    userId: "user3",
    username: "Bob Johnson",
    rating: 5,
    text: "A chilling and thought-provoking novel. Orwell's vision of the future is haunting.",
  },
];

// Simulate
let currentUser = JSON.parse(localStorage.getItem("currentUser")) || null;

function login(email, password) {
  // Simulate
  currentUser = { email, nickname: email.split("@")[0] };
  localStorage.setItem("currentUser", JSON.stringify(currentUser));
  updateUserNav();
  window.location.href = "index.html";
}

function logout() {
  currentUser = null;
  localStorage.removeItem("currentUser");
  updateUserNav();
  window.location.href = "index.html";
}

function register(username, email, password) {
  // Simulate
  currentUser = { email, nickname: username };
  localStorage.setItem("currentUser", JSON.stringify(currentUser));
  updateUserNav();
  window.location.href = "index.html";
}

function updateUserNav() {
  const userNav = document.getElementById("user-nav");
  if (userNav) {
    if (currentUser) {
      userNav.innerHTML = `
                <a href="profile.html">${currentUser.nickname}</a>
                <a href="#" id="logout-link">Logout</a>
            `;
      document.getElementById("logout-link").addEventListener("click", (e) => {
        e.preventDefault();
        logout();
      });
    } else {
      userNav.innerHTML = `
                <a href="login.html">Login</a>
                <a href="register.html">Register</a>
            `;
    }
  }
}

function renderStars(rating) {
  const fullStars = Math.floor(rating);
  const halfStar = rating % 1 >= 0.5 ? 1 : 0;
  const emptyStars = 5 - fullStars - halfStar;

  return `
        ${'<i class="fas fa-star"></i>'.repeat(fullStars)}
        ${halfStar ? '<i class="fas fa-star-half-alt"></i>' : ""}
        ${'<i class="far fa-star"></i>'.repeat(emptyStars)}
    `;
}

function renderBooks() {
  const booksGrid = document.getElementById("books-grid");
  const sortSelect = document.getElementById("sort-select");

  if (!booksGrid || !sortSelect) return;

  const sortedBooks = [...books].sort((a, b) => {
    const order = sortSelect.value === "asc" ? 1 : -1;
    return order * a.title.localeCompare(b.title);
  });

  booksGrid.innerHTML = sortedBooks
    .map(
      (book) => `
        <div class="book-card">
            <img src="${book.image}" alt="${book.title}">
            <div class="book-info">
                <h3 class="book-title" title="${book.title}">
                    ${
                      book.title.length > 20
                        ? book.title.substring(0, 20) + "..."
                        : book.title
                    }
                </h3>
                <p class="book-author">${book.author}</p>
                <div class="book-rating">
                    <span class="stars">${renderStars(book.rating)}</span>
                    <span class="rating-value">${book.rating.toFixed(1)}</span>
                </div>
                <a href="book-details.html?id=${
                  book.id
                }" class="read-review">Read Review</a>
            </div>
        </div>
    `
    )
    .join("");
}

function renderBookDetails() {
  const bookDetails = document.getElementById("book-details");
  const reviewSection = document.getElementById("review-section");

  if (!bookDetails || !reviewSection) return;

  const urlParams = new URLSearchParams(window.location.search);
  const bookId = parseInt(urlParams.get("id"));
  const book = books.find((b) => b.id === bookId);

  if (!book) {
    bookDetails.innerHTML = "<p>Book not found</p>";
    return;
  }

  bookDetails.innerHTML = `
        <div class="book-details-content">
            <img src="${book.image}" alt="${
    book.title
  }" class="book-details-image">
            <div class="book-details-info">
                <h2>${book.title}</h2>
                <p class="book-author">by ${book.author}</p>
                <div class="book-rating">
                    <span class="stars">${renderStars(book.rating)}</span>
                    <span class="rating-value">${book.rating.toFixed(1)}</span>
                </div>
                <p class="book-description">${book.description}</p>
                <div class="book-metadata">
                    <p><strong>Pages:</strong> ${book.pages}</p>
                    <p><strong>Publisher:</strong> ${book.publisher}</p>
                    <p><strong>Year:</strong> ${book.year}</p>
                    <p><strong>Country:</strong> ${book.country}</p>
                </div>
            </div>
        </div>
    `;

  const bookReviews = reviews.filter((review) => review.bookId === bookId);

  let reviewContent = "<h3>Reviews</h3>";

  if (currentUser) {
    reviewContent += `
            <form id="review-form" class="review-form">
                <div class="rating">
                    <input type="radio" id="star5" name="rating" value="5" required><label for="star5"></label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
                </div>
                <textarea id="review-text" placeholder="Write your review here" required></textarea>
                <button type="submit">Submit Review</button>
            </form>
        `;
  }

  reviewContent += '<div class="reviews-list">';
  if (bookReviews.length > 0) {
    reviewContent += bookReviews
      .map(
        (review) => `
            <div class="review">
                <div class="review-header">
                    <span class="review-author">${review.username}</span>
                    <span class="review-rating">
                        ${renderStars(review.rating)}
                    </span>
                </div>
                <p class="review-text">${review.text}</p>
            </div>
        `
      )
      .join("");
  } else {
    reviewContent += "<p>No reviews yet.</p>";
  }
  reviewContent += "</div>";

  reviewSection.innerHTML = reviewContent;

  if (currentUser) {
    const reviewForm = document.getElementById("review-form");
    reviewForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const rating = document.querySelector(
        'input[name="rating"]:checked'
      ).value;
      const text = document.getElementById("review-text").value;
      addReview(bookId, parseInt(rating), text);
      renderBookDetails();
    });
  }
}

function addReview(bookId, rating, text) {
  const newReview = {
    id: reviews.length + 1,
    bookId: bookId,
    userId: currentUser.email,
    username: currentUser.nickname,
    rating: rating,
    text: text,
  };
  reviews.push(newReview);
}

document.addEventListener("DOMContentLoaded", () => {
  updateUserNav();

  if (document.getElementById("books-grid")) {
    renderBooks();
    document
      .getElementById("sort-select")
      .addEventListener("change", renderBooks);
  }

  if (document.getElementById("book-details")) {
    renderBookDetails();
  }

  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      login(email, password);
    });
  }

  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const username = document.getElementById("username").value;
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      register(username, email, password);
    });
  }

  const profileInfo = document.getElementById("profile-info");
  if (profileInfo && currentUser) {
    profileInfo.innerHTML = `
            <p><strong>Username:</strong> ${currentUser.nickname}</p>
            <p><strong>Email:</strong> ${currentUser.email}</p>
        `;
  }
});
