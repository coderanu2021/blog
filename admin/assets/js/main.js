 /* header */

 const profileIcon = document.getElementById('profileIcon');
  const profileDropdown = document.getElementById('profileDropdown');

  profileIcon.addEventListener('click', () => {
    profileDropdown.style.display = profileDropdown.style.display === 'block' ? 'none' : 'block';
  });

  // Optional: Close dropdown if clicked outside
  document.addEventListener('click', function(e) {
    if (!profileIcon.contains(e.target)) {
      profileDropdown.style.display = 'none';
    }
  });