<!-- Google Fonts: Lora (Consistent Editorial Botanical Typography) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

<!-- Font Awesome 6 Free (Icons) -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Tailwind Theme Configuration mapped to CSS Variables -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Lora', 'Georgia', 'serif'],
                    serif: ['Lora', 'Georgia', 'serif'],
                },
                colors: {
                    flora: {
                        fog: '#DDD3C9',
                        berry: '#ECC4C3',
                        blossom: '#B97D7B',
                        mauve: '#928E5E',
                        green: '#575527',
                        surface: '#FAF7F3',
                        subtle: '#EFE8E0',
                        muted: '#6E6B47',
                    }
                }
            }
        }
    }
</script>

<!-- Shared Flora Design Tokens & Component Styles -->
<link rel="stylesheet" href="{{ asset('css/flora-theme.css') }}">
