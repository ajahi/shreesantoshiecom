const getters = {
    sidebar: state => state.app.sidebar,
    device: state => state.app.device,
    app: state => state.app.app,
    token: state => state.user.token,
    userid: state => state.user.id,
    userrole: state => state.user.roles,
    useremail: state => state.user.email,
    useractive: state => state.user.active,
    userverified: state => state.user.verified,

    avatar: state => state.user.avatar,
    visitedViews: state => state.tagsView.visitedViews,
    cachedViews: state => state.tagsView.cachedViews,

}
export default getters
