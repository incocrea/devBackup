// Debounced resize event (width only). [ref: https://paulbrowne.xyz/debouncing]
var _resize = function (a, b) {
  var c = [window.innerWidth]
  return window.addEventListener('resize', function () {
    var e = c.length
    c.push(window.innerWidth)
    if (c[e] !== c[e - 1]) {
      clearTimeout(b)
      b = setTimeout(a, 150)
    }
  }), a
}

// Bootstrap BreakPoint Checker
var breakPoint = function (value) {
  var el, check, cls

  switch (value) {
    case 'xs':
      cls = 'd-none d-sm-block'
      break
    case 'sm':
      cls = 'd-block d-sm-none d-md-block'
      break
    case 'md':
      cls = 'd-block d-md-none d-lg-block'
      break
    case 'lg':
      cls = 'd-block d-lg-none d-xl-block'
      break
    case 'xl':
      cls = 'd-block d-xl-none'
      break
  }

  el = $('<div/>', {
    'class': cls
  }).appendTo('body')

  check = el.is(':hidden')
  el.remove()

  return check
}
var xs = function () {
  return breakPoint('xs')
}
var sm = function () {
  return breakPoint('sm')
}
var md = function () {
  return breakPoint('md')
}
var lg = function () {
  return breakPoint('lg')
}
var xl = function () {
  return breakPoint('xl')
}

$(function () {
  var body = $('body')
  var mainContainer = $('#main-container')

  // This is for development, attach breakpoint to document title
  /*var docTitle = document.title
  _resize(function () {
    if (xs()) {
      document.title = '(xs) ' + docTitle
    } else if (sm()) {
      document.title = '(sm) ' + docTitle
    } else if (md()) {
      document.title = '(md) ' + docTitle
    } else if (lg()) {
      document.title = '(lg) ' + docTitle
    } else if (xl()) {
      document.title = '(xl) ' + docTitle
    }
  })()*/

  // Form search, prevent submit on empty value
  $('.form-search').submit(function (event) {
    var searchInput = $(this).find('input')
    if (searchInput.val() == '') {
      searchInput.focus()
      event.preventDefault()
    }
  })

  // Perfect Scrollbar for main sidebar
  var psSidebar = new PerfectScrollbar('#main-sidebar', { wheelPropagation: false })

  // MORE & LESS toggle
  $('#main-sidebar .toggle').click(function () {
    var toggler = $(this)
    if (toggler.attr('aria-expanded') == 'true') {
      toggler.html('MORE &#9662;')
    } else {
      toggler.html('LESS &#9652;')
    }
  })

  // Update Perfect Scrollbar
  $('#main-sidebar .collapse').on('shown.bs.collapse', function () {
    psSidebar.update()
  })
  $('#main-sidebar .collapse').on('hidden.bs.collapse', function () {
    psSidebar.update()
  })

  // Toggle sidebar collapse (md down)
  $('.toggle-menu').click(function () {
    mainContainer.toggleClass('sidebar-collapse')
    if (!lg() && !xl() && !mainContainer.hasClass('sidebar-collapse')) {
      body.addClass('modal-open').append('<div class="sidebar-backdrop"></div>')
    } else {
      body.removeClass('modal-open').find('.sidebar-backdrop').remove()
    }
    $(document).trigger('sidebar.changed')
  })

  // Force to collapse sidebar on md down
  _resize(function () {
    if (!lg() && !xl()) {
      mainContainer.addClass('sidebar-collapse')
      $('body').removeClass('modal-open').find('.sidebar-backdrop').remove()
      $(document).trigger('sidebar.changed')
    } else {
      mainContainer.removeClass('sidebar-collapse')
      $(document).trigger('sidebar.changed')
    }
  })()

  // Close sidebar when clicked outside sidebar
  $(document).on('click', '.sidebar-backdrop', function (event) {
    $('.toggle-menu').trigger('click')
    event.preventDefault()
  })

  // Toggle Search Form
  $('#search-toggle').click(function (event) {
    $('.form-search').toggleClass('d-none').find('.form-control').focus()
    event.preventDefault()
  })
  $('.btn-search-back').click(function (event) {
    $('.form-search').toggleClass('d-none')
    event.preventDefault()
  })

})
