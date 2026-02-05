
            // Unique input names
    function greet(name) {
      const returningUsers = ["Jair", "Maria"];
      return returningUsers.includes(name)
        ? `Hello, ${name}! Nice to see you again!`
        : `Hello, ${name || "stranger"}!`;
    }

    // Function triggered when the button is clicked
    function showGreeting() {
      const name = document.getElementById("nameInput").value.trim();
      const message = greet(name);
      document.getElementById("greeting").textContent = message;
    }
    
    function myFunction() {
            var element = document.body;
            element.classList.toggle("dark-mode");
            }

            fetch('session.php')
          .then(response => response.json())
          .then(data => {
            const greeting = document.getElementById('userGreeting');
            if (data.fullname) {
              greeting.textContent = `Welcome, ${data.fullname} (${data.email})`;
            } else {
              greeting.textContent = '';
            }
          })
          .catch(() => {
            document.getElementById('userGreeting').textContent = '';
          });

          //function to generate random quote from michael G Scott
          const quotes = [
            "Limitless paper in a paperless world.",
            "Paper is like oxygen for businesses.",
            "We don't sell paper. We sell possibilities.",
            "I am Beyonce, always!",
            "It's Bittany bitch."
          ];

          let remainingIndexes = [];

  function shuffleArray(arr) {
    for (let i = arr.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
  }

  function refillIndexes() {
    remainingIndexes = shuffleArray([...Array(quotes.length).keys()]);
  }

  function showQuote() {
    const display = document.getElementById('quoteDisplay');
    const counter = document.getElementById('quoteCounter');

    if (remainingIndexes.length === 0) {
      refillIndexes(); // all shown, reshuffle and start over
    }

    const idx = remainingIndexes.pop(); // take one index
    const q = quotes[idx];

    // simple fade-in using opacity and transition
    display.style.transition = "opacity 300ms ease";
    display.style.opacity = 0;
    // set text after tiny delay so transition is visible
    setTimeout(() => {
      display.textContent = q;
      display.style.opacity = 1;
    }, 50);

    // update counter (e.g., "2 of 5 left")
    const left = remainingIndexes.length;
    counter.textContent = `${left} quote${left !== 1 ? 's' : ''} left before repeat.`;
  }

  document.addEventListener('DOMContentLoaded', () => {
    refillIndexes();
    document.getElementById('quoteBtn').addEventListener('click', showQuote);
  });
