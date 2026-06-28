window.hyvaTabsToolbar = function (initialCollide, firstAlias) {
    return {
        collide: initialCollide,
        firstAlias: firstAlias,
        lastActiveAlias: firstAlias,

        init() {
            this.$nextTick(() => {
                this.updateAllCollisions();
            });
        },

        isActive(alias) {
            const keys = Object.keys(this.collide);
            const activeTab = keys.filter(key => this.collide[key] === true).pop();
            
            if (activeTab) {
                this.lastActiveAlias = activeTab;
                return activeTab === alias;
            }

            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const toolbarHeight = this.$el.clientHeight;

            const firstPanel = document.getElementById(this.firstAlias);
            const lastPanel = document.getElementById(keys[keys.length - 1]);

            if (firstPanel && lastPanel) {
                const firstPanelTop = firstPanel.getBoundingClientRect().top + scrollTop - toolbarHeight;
                const lastPanelBottom = lastPanel.getBoundingClientRect().top + scrollTop + lastPanel.clientHeight - toolbarHeight;

                if (scrollTop < firstPanelTop) {
                    this.lastActiveAlias = this.firstAlias;
                } else if (scrollTop > lastPanelBottom) {
                    this.lastActiveAlias = keys[keys.length - 1];
                }
            }

            return this.lastActiveAlias === alias;
        },

        scrollToPanel(alias) {
            const panel = document.getElementById(alias);
            if (!panel) return;

            const panelTop = panel.getBoundingClientRect().top + (window.pageYOffset || document.documentElement.scrollTop);
            const toolbarHeight = this.$el.clientHeight;
            const targetScrollTop = panelTop - toolbarHeight;

            window.scrollTo({
                top: targetScrollTop,
                behavior: 'smooth'
            });
        },

        updateAllCollisions() {
            Object.keys(this.collide).forEach(alias => {
                this.checkCollision(alias);
            });
        },

        checkCollision(alias) {
            const panel = document.getElementById(alias);
            if (!panel) return;

            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const toolbarHeight = this.$el.clientHeight;

            const panelTop = panel.getBoundingClientRect().top + scrollTop;
            const panelBottom = panelTop + panel.clientHeight;
            const triggerLine = scrollTop + toolbarHeight + 100;

            this.collide[alias] = triggerLine >= panelTop && scrollTop + toolbarHeight < panelBottom;
        }
    };
};