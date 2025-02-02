<div class="sidebar sidebar-style-2">
    <div id="sidebar" class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                {{-- <div class="avatar-sm float-left mr-2">
                </div> --}}
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            @{{ user.name }}
                            <span class="user-level">@{{ user.role_name_list ? user.role_name_list.join(", ") : '' }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            {{-- <li>
                                <a href="#profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#edit">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li> --}}
                            <li>
                                <a href="#" @click="logout">
                                    <span class="link-collapse">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <template v-for="(menu, index) in menus">
                    <template v-if="menu.childs.length > 0">
                        <li :class="`nav-item ${ activeParentMenu == menu.name ? 'active' : ''}`"
                            @click="setActiveParentMenu(menu.name)">
                            <a data-toggle="collapse" :href="`#${menu.name.split('').join('')}`">
                                <i :class="menu.icon"></i>
                                <p>@{{ menu.name }}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" :id="menu.name.split('').join('')">
                                <ul class="nav nav-collapse">
                                    <template v-for="(childMenu, childIndex) in menu.childs">
                                        <li :class="`${ activeMenu == childMenu.name ? 'active' : ''}`"
                                            @click="setActiveMenu(childMenu.name)">
                                            <a :href="`{{ url('') }}/${childMenu.path}`">
                                                <span :href="`{{ url('') }}/${childMenu.path}`"
                                                    class="sub-item">@{{ childMenu.name }}</span>
                                            </a>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item ${ activeParentMenu == menu.name ? 'active' : ''}`">
                            <a :href="`{{ url('') }}/${menu.path}`">
                                <i class="fas fa-layer-group"></i>
                                <span :href="`{{ url('') }}/${menu.path}`"
                                    class="sub-item">@{{ menu.name }}</span>
                            </a>
                        </li>
                    </template>
                </template>
            </ul>
        </div>
    </div>
    <script >
        createApp({
            data() {
                return {
                    menus: [],
                    activeMenu: '',
                    activeParentMenu: '',
                    user: {},
                }
            },
            created() {
                this.fetchMenu()
                this.fetchUser()
            },
            methods: {
                setActiveMenu(activeMenu) {
                    this.activeMenu = activeMenu
                },
                setActiveParentMenu(activeMenu) {
                    this.activeParentMenu = activeMenu
                },
                async fetchUser() {
                    try {
                        const response = await httpClient.get('{{ url('') }}/user/me');
                        this.user = response.data.result;
                    } catch (err) {
                        showToast({
                            message: err.message,
                            type: 'warning'
                        })
                    }
                },
                async fetchMenu() {
                    try {
                        const response = await httpClient.get('{{ url('') }}/menu/mine');
                        this.menus = response.data.result;
                    } catch (err) {
                        showToast({
                            message: err.message,
                            type: 'warning'
                        })
                    }
                },
                async logout() {
                    showLoading()
                    try {
                        await httpClient.get("{{ url('') }}/user/logout")
                        location.href = "{{ url('') }}/user/login"
                    } catch (err) {
                        console.log(err)
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'warning'
                        })
                    }
                }
            },
        }).mount("#sidebar")
    </script>
</div>
