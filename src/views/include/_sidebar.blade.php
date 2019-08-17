<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>

<div id="m_aside_left" class="m-grid__item	m-aside-left m-aside-left--skin-dark">
    <div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow">
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                    Finance & Accounting
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="/" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-text">Dashboard</span>
                </a>
            </li>

            <li class="m-menu__item" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="{{route('cashbook.index')}}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-3"></i>
                    <span class="m-menu__link-text">Cashbook</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-list-3"></i><span class="m-menu__link-text">Master</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('coa.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">COA</span></a></li>
            </li>

        </ul>
    </div>
    </li>

    </ul>
</div>
</div>