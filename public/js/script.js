
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('register-form');
  
  if (form) {
  form.addEventListener('submit', function(e) {
      e.preventDefault();

      
      document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

      const username = document.getElementById('username').value.trim();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
      const profilePhoto = document.getElementById('profile-photo').files[0];

      let isValid = true;

      if (username.length < 3) {
          document.getElementById('username-error').textContent = 'Username must be at least 3 characters long.';
          isValid = false;
      }

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
          document.getElementById('email-error').textContent = 'Please enter a valid email address.';
          isValid = false;
      }

  
      if (password.length < 8) {
          document.getElementById('password-error').textContent = 'Password must be at least 8 characters long.';
          isValid = false;
      }

     
      if (password !== confirmPassword) {
          document.getElementById('confirm-password-error').textContent = 'Passwords do not match.';
          isValid = false;
      }

     
      if (!profilePhoto) {
          document.getElementById('profile-photo-error').textContent = 'Please select a profile photo.';
          isValid = false;
      }

      if (isValid) {
          form.submit();
      }
  });
}});

document.addEventListener('DOMContentLoaded', function() {
  const reviewForm = document.getElementById('review-form');
  const bookId = new URLSearchParams(window.location.search).get('id');

  if (reviewForm) {
    reviewForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      let rating = document.querySelector('input[name="rating"]:checked');
      let reviewText = document.getElementById('review-text').value;

      if (rating && reviewText.trim() !== '') {
        fetch('index.php?page=review/add', {
          method: 'POST',
          body: new FormData(this),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            updateBookRating(data.newRating);
            this.reset();
            loadReviews(); 
          } else {
            alert(data.error || 'Failed to add review');
          }
        })
        .catch(error => console.error('Error:', error));
      } else {
        alert('Please provide both a rating and a review text');
      }
    });
  }

  function updateBookRating(newRating) {
    const ratingElement = document.querySelector('.book-rating .rating-value');
    const starsElement = document.querySelector('.book-rating .stars');
    if (ratingElement && starsElement) {
      ratingElement.textContent = newRating;
      const roundedRating = Math.round(newRating);
      starsElement.innerHTML = '★'.repeat(roundedRating) + '☆'.repeat(5 - roundedRating);
    }
  }

  function loadReviews() {
    if (!bookId) {
      console.error('Book ID not found');
      return;
    }

    fetch(`index.php?page=book&id=${bookId}`)
    .then(response => response.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const reviewsList = doc.getElementById('reviews-list');
      if (reviewsList) {
        document.getElementById('reviews-list').innerHTML = reviewsList.innerHTML;
      }
    })
    .catch(error => console.error('Error loading reviews:', error));
  }

  if (bookId) {
    loadReviews();
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const bookForm = document.getElementById('add-book-form') || document.getElementById('edit-book-form');
  if (bookForm) {
      bookForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          
          document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

          
          let title = document.getElementById('title').value.trim();
          let author = document.getElementById('author').value.trim();
          let description = document.getElementById('description').value.trim();
          let pages = document.getElementById('pages').value.trim();
          let publisher = document.getElementById('publisher').value.trim();
          let year = document.getElementById('year').value.trim();
          let country = document.getElementById('country').value.trim();
          let cover = document.getElementById('image').files[0];

          let isValid = true;

        
          if (title.length < 3) {
              document.getElementById('title-error').textContent = 'Title must be at least 3 characters long.';
              isValid = false;
          }
      
         
          if (author.length < 3) {
              document.getElementById('author-error').textContent = 'Author name must be at least 3 characters long.';
              isValid = false;
          }
      
       
          if (description.length < 10) {
              document.getElementById('description-error').textContent = 'Description must be at least 10 characters long.';
              isValid = false;
          }
      
          if (isNaN(pages) || pages <= 0) {
              document.getElementById('pages-error').textContent = 'Please enter a valid number of pages.';
              isValid = false;
          }
      
        
          if (publisher.length < 3) {
              document.getElementById('publisher-error').textContent = 'Publisher name must be at least 3 characters long.';
              isValid = false;
          }
      
         
          if (isNaN(year) || year <= 0 || year > new Date().getFullYear()) {
              document.getElementById('year-error').textContent = 'Please enter a valid publication year.';
              isValid = false;
          }
      
         
          if (country.length < 3) {
              document.getElementById('country-error').textContent = 'Country name must be at least 3 characters long.';
              isValid = false;
          }
      
        
          if (bookForm.id === 'add-book-form' && !cover) {
              document.getElementById('book-cover-error').textContent = 'Please select a book cover.';
              isValid = false;
          }

         
          if (isValid) {
              this.submit();
          }
      });
  }
});



document.addEventListener('DOMContentLoaded', function () {
 
  const changePasswordForm = document.getElementById('change-password');

  if (changePasswordForm) {
    
    changePasswordForm.addEventListener('submit', function (e) {
      e.preventDefault(); 

   
      document.querySelectorAll('.error-message').forEach(el => (el.textContent = ''));

      
      const currentPassword = document.getElementById('current-password').value.trim();
      const newPassword = document.getElementById('new-password').value.trim();
      const confirmPassword = document.getElementById('confirm-password').value.trim();

      let isValid = true;

    
      if (!currentPassword) {
        document.getElementById('current-password-error').textContent = 'Current password is required.';
        isValid = false;
      }

      
      if (newPassword.length < 8) {
        document.getElementById('new-password-error').textContent = 'New password must be at least 8 characters long.';
        isValid = false;
      }

     
      if (newPassword !== confirmPassword) {
        document.getElementById('confirm-password-error').textContent = 'Passwords do not match.';
        isValid = false;
      }


      if (isValid) {
        this.submit();
      }
    });
  }
});




