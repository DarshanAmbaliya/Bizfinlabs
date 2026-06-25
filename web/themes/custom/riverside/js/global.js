(function (Drupal, once) {
  Drupal.behaviors.mobileMenuToggle = {
    attach(context) {
      once('mobileMenuToggle', '#mobileMenu', context).forEach((menuButton) => {

        const menuContainer = document.querySelector('.main-menu-div');
        const body = document.body;

        if (!menuContainer) {
          return;
        }

        function openMenu() {
          menuContainer.hidden = false;

          menuButton.classList.add('active');
          menuContainer.classList.add('active');

          menuButton.setAttribute('aria-expanded', 'true');
          menuButton.setAttribute('aria-label', 'Close navigation menu');

          body.classList.add('overflow-hidden');

          menuContainer.querySelector('a')?.focus();
        }

        function closeMenu() {
          menuContainer.hidden = true;

          menuButton.classList.remove('active');
          menuContainer.classList.remove('active');

          menuButton.setAttribute('aria-expanded', 'false');
          menuButton.setAttribute('aria-label', 'Open navigation menu');

          body.classList.remove('overflow-hidden');

          menuButton.focus();
        }

        menuButton.addEventListener('click', () => {
          const isOpen =
            menuButton.getAttribute('aria-expanded') === 'true';

          isOpen ? closeMenu() : openMenu();
        });

        document.addEventListener('keydown', (event) => {
          if (
            event.key === 'Escape' &&
            menuButton.getAttribute('aria-expanded') === 'true'
          ) {
            closeMenu();
          }
        });
      });
    }
  };
})(Drupal, once);