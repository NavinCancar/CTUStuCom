<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CTU Student Community</title>
  <link rel="shortcut icon" type="image/png" href="{{('public/images/logos/logo.png')}}" />

  <!--css-->
  <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('public/css/tokenfield.css')}}" />
  <link rel="stylesheet" href="{{asset('public/css/style.css')}}">

  <!--fontawesome-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

  <!-- Scroll bar -->
  <style>
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb {
      background: #bebebe;
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #a5a5a5;
    }
  </style>
</head>

<body>
  <?php $userLog= Session::get('userLog'); ?>

  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    @include('main_component.left-sidebar')
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      @include('main_component.header')
      <!--  Header End -->

      <!-- Content Start -->
      @yield('content')
    </div>
  </div>


  <!-- js -->
  <script src="{{asset('public/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('public/js/app.min.js')}}"></script>
  <script src="{{asset('public/js/nav-search.js')}}"></script>

  <!--Xử lý hashtag Start-->
  <script src="{{asset('public/js/tokenfield.web.js')}}"></script>
  
  <script>
    //Thêm bài
    const myItems = [
      { name: 'JavaScript' },
      { name: 'HTML' },
      { name: 'CSS' },
      { name: 'Angular' },
      { name: 'React' },
      { name: 'can_tho' },
    ];
    const instance = new Tokenfield({
      el: document.querySelector('.basic'),
      items: myItems,

      form: true, // Listens to reset event
      mode: 'tokenfield', // tokenfield or list.
      addItemOnBlur: false,
      addItemsOnPaste: false,
      keepItemsOrder: true,
      setItems: [], // array of pre-selected items
      newItems: true,
      multiple: true,
      maxItems: 5,
      minLength: 1,
      keys: {
        17: 'ctrl',
        16: 'shift',
        91: 'meta',
        8: 'delete', // Backspace
        27: 'esc',
        37: 'left',
        38: 'up',
        39: 'right',
        40: 'down',
        46: 'delete',
        65: 'select', // A
        67: 'copy', // C
        88: 'cut', // X
        9: 'delimiter', // Tab
        13: 'delimiter', // Enter
        108: 'delimiter' // Numpad Enter
      },
      matchRegex: '{value}',
      matchFlags: 'i',
      matchStart: false,
      matchEnd: false,
      delimiters: [], // array of strings
      copyProperty: 'name',
      copyDelimiter: ', ',
      placeholder: null,
      inputType: 'text',
      minChars: 0,
      maxSuggest: 10,
      maxSuggestWindow: 10,
      filterSetItems: true,
      filterMatchCase: false,
      singleInput: false, // true, 'selector', or an element.
      singleInputValue: 'name',
      singleInputDelimiter: ', ',
      itemLabel: 'name',
      itemName: 'items',
      newItemName: 'items_new',
      itemValue: 'name',
      newItemValue: 'name',
      itemData: 'name',
      validateNewItem: null
    });

    /*
    const instance = new Tokenfield({
          el: document.querySelector('.basic'),
          remote: {
            type: 'GET', // GET or POST
            url: null, // Full url.
            queryParam: 'q', // query parameter
            delay: 300, // delay in ms
            timestampParam: 't',
            params: {},
            headers: {}
          },
    });*/
    // Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
    instance.on('change', () => {
      const selectedItems = instance.getItems();
      const outputDiv = document.querySelector('.output');
      outputDiv.innerHTML = `Mục đã chọn: ${selectedItems.map(item => item.name).join(', ')}`;
    });
  </script>

  <script>
    //Lọc bài
      const myItems2 = [
        { name: 'k49' },
        { name: 'tsv' },
        { name: 'pass_tai_lieu' },
        { name: 'mail' },
        { name: 'cit' },
        { name: 'can_tho' },
      ];
      const instance2 = new Tokenfield({
        el: document.querySelector('.basic2'),
        items: myItems2,

        form: true, // Listens to reset event
        mode: 'tokenfield', // tokenfield or list.
        addItemOnBlur: false,
        addItemsOnPaste: false,
        keepItemsOrder: true,
        setItems: [], // array of pre-selected items
        newItems: false,
        multiple: true,
        minLength: 0,
        keys: {
          17: 'ctrl',
          16: 'shift',
          91: 'meta',
          8: 'delete', // Backspace
          27: 'esc',
          37: 'left',
          38: 'up',
          39: 'right',
          40: 'down',
          46: 'delete',
          65: 'select', // A
          67: 'copy', // C
          88: 'cut', // X
          9: 'delimiter', // Tab
          13: 'delimiter', // Enter
          108: 'delimiter' // Numpad Enter
        },
        matchRegex: '{value}',
        matchFlags: 'i',
        matchStart: false,
        matchEnd: false,
        delimiters: [], // array of strings
        copyProperty: 'name',
        copyDelimiter: ', ',
        placeholder: null,
        inputType: 'text',
        minChars: 1,
        maxSuggest: 10,
        maxSuggestWindow: 10,
        filterSetItems: true,
        filterMatchCase: false,
        singleInput: false, // true, 'selector', or an element.
        singleInputValue: 'name',
        singleInputDelimiter: ', ',
        itemLabel: 'name',
        itemName: 'items',
        newItemName: 'items_new',
        itemValue: 'name',
        newItemValue: 'name',
        itemData: 'name',
        validateNewItem: null
      });

      /*
      const instance = new Tokenfield({
            el: document.querySelector('.basic'),
            remote: {
              type: 'GET', // GET or POST
              url: null, // Full url.
              queryParam: 'q', // query parameter
              delay: 300, // delay in ms
              timestampParam: 't',
              params: {},
              headers: {}
            },
      });*/
      // Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
      instance2.on('change', () => {
        const selectedItems2 = instance2.getItems();
        const outputDiv2 = document.querySelector('.output2');
        outputDiv2.innerHTML = `Mục đã chọn: ${selectedItems2.map(item => item.name).join(', ')}`;
      });
  </script>
  <!--Xử lý hashtag End-->
</body>

</html>