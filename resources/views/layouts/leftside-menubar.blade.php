<style>
  .nav-item.active {
    background-color: #fce8e6;
    font-weight: bold;
  }

  /*.nav-item.active a {
    color: #d93025;
  }*/

  .nav-link-text {
    padding-left: 10%;
  }

  #side-navbar ul>li>a {
    padding: 8px 15px;
  }
</style>
<ul class="nav flex-column">
  <li class="nav-item active">
    <a class="nav-link" href="{{ url('dashboard') }}"><i class="fab fa-dashcube"></i> <span class="nav-link-text">@lang('Dashboard')</span></a>
  </li>
  @if(Auth::user()->is_active)
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="fas fa-users"></i> <span class="nav-link-text">@lang('Students')</span> <i class="fas fa-angle-down pull-right"></i></a>
        <ul class="dropdown-menu" style="width: 100%;">
        <!-- Dropdown menu links -->
          <li>
            <a class="dropdown-item" href="{{ url('search_family') }}"><i class="fas fa-plus"></i> <span class="nav-link-text">Add Student</span></a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ url('students/list') }}"><i class="fas fa-list"></i> <span
                class="nav-link-text">Students</span></a>
          </li>
        </ul>
  </li>
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="far fa-money-bill-alt"></i> <span class="nav-link-text">@lang('Fees Management')</span> <i class="fas fa-angle-down pull-right"></i>
    </a>
    <ul class="dropdown-menu" style="width: 100%;">
    <!-- Dropdown menu links -->
      <li>
        <a class="dropdown-item" href="{{ url('search_student') }}"><i class="fas fa-plus"></i> <span class="nav-link-text">Add Fees</span></a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ url('search-fees-detail') }}"><i class="fas fa-list"></i> <span
            class="nav-link-text">Fees Details</span></a>
      </li>
    </ul>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('edit_class') }}"><i class="fas fa-house-user"></i> <span class="nav-link-text">Class</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('attendence') }}"><i class="fas fa-users"></i> <span class="nav-link-text">Attendence</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('test-marks-sheet') }}"><i class="fas fa-poll"></i> <span class="nav-link-text">Test Marks Sheet</span></a>
  </li>
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="fas fa-poll"></i> <span class="nav-link-text">@lang('Result Management')</span> <i class="fas fa-angle-down pull-right"></i>
    </a>
    <ul class="dropdown-menu" style="width: 100%;">
    <!-- Dropdown menu links -->
      <li>
        <a class="dropdown-item" href="{{ url('result/upload') }}"><i class="fas fa-plus"></i> <span class="nav-link-text">Upload Result</span></a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ url('search-fees-detail') }}"><i class="fas fa-file-download"></i> <span
            class="nav-link-text">Download Result</span></a>
      </li>
    </ul>
  </li>
  @endif
</ul>
