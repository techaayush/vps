<script>
  $(document).ready(function () {
    $('.nav-item.active').removeClass('active');
    $('a[href="' + window.location.href + '"]').closest('li').closest('ul').closest('li').addClass('active');
    $('a[href="' + window.location.href + '"]').closest('li').addClass('active');
  });
</script>
<style>
  .nav-item.active {
    background-color: #fce8e6;
    font-weight: bold;
  }

  .nav-item.active a {
    color: #d93025;
  }

  .nav-link-text {
    padding-left: 10%;
  }

  #side-navbar ul>li>a {
    padding: 8px 15px;
  }
</style>
<ul class="nav flex-column">
  <li class="nav-item active">
    <a class="nav-link" href=""><i class="material-icons">dashboard</i> <span class="nav-link-text">@lang('Dashboard')</span></a>
  </li>
  @if(Auth::user()->is_active)
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="material-icons">contacts</i> <span class="nav-link-text">@lang('Students')</span> <i class="material-icons pull-right">keyboard_arrow_down</i></a>
        <ul class="dropdown-menu" style="width: 100%;">
        <!-- Dropdown menu links -->
          <li>
            <a class="dropdown-item" href="{{ url('search_family') }}"><i class="material-icons">note_add</i> <span class="nav-link-text">Search Student Family</span></a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ url('exams/active') }}"><i class="material-icons">developer_board</i> <span
                class="nav-link-text">Edit Students</span></a>
          </li>
        </ul>
  </li>
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="material-icons">contacts</i> <span class="nav-link-text">@lang('Fees Management')</span> <i class="material-icons pull-right">keyboard_arrow_down</i></a>
        <ul class="dropdown-menu" style="width: 100%;">
        <!-- Dropdown menu links -->
          <li>
            <a class="dropdown-item" href="{{ url('search_student') }}"><i class="material-icons">note_add</i> <span class="nav-link-text">Add Fees</span></a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ url('exams/active') }}"><i class="material-icons">developer_board</i> <span
                class="nav-link-text">Print Receipt</span></a>
          </li>
        </ul>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('edit_class') }}"><i class="material-icons">class</i> <span class="nav-link-text">Class</span></a>
  </li>
  @endif
</ul>
