document.addEventListener('DOMContentLoaded',  async () => {
    const onboardingUsersGraph = new Graph({
        dataSourceUrl: '/api/onboarding/users',
        targetDomNodeId: 'onboardingUsersGraph'
    });
    await onboardingUsersGraph.load();
    onboardingUsersGraph.render();
});

