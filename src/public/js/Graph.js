/**
 * @typedef {{dataSourceUrl: string, targetDomNodeId: string}} GraphConfig
 * @typedef {{user_id: number, created_at: string, onboarding_perentage: number, count_applications: number, count_accepted_applications: number}} OnboardingUser
 */

class Graph {
    /**
     * @var {GraphConfig}
     */
    #config;

    /**
     * @var {OnboardingUser[]}
     */
    #data;

    /**
     * @var {{}}
     */
    #dataJson;

    /**
     * @param {GraphConfig} config
     */
    constructor(config) {
        assert(typeof config === 'object');
        assert(typeof config.dataSourceUrl === 'string' && config.dataSourceUrl);
        assert(typeof config.targetDomNodeId === 'string' && config.targetDomNodeId);

        this.#config = config;
    }

    /**
     * @returns {Promise<void>}
     */
    async load() {
        const resp = await fetch(this.#config.dataSourceUrl);
        if (!resp.ok) {
            throw new Error(
                `An HTTP request to "${this.#config.dataSourceUrl}" has failed with a ${resp.status} error.`
            );
        }

        this.#dataJson = resp;
    }

    /**
     * @returns {Promise<{}>}
     */
    async getJson() {
        if (this.#data === undefined) {
            this.#data = await this.#dataJson.json();
        }

        return this.#data;
    }

    // @TODO This method should come from the Renderer interface, which would provide different rendering ways
    render() {
        Highcharts.chart(this.#config.targetDomNodeId, {
            title: {
                text: 'Users retention chart'
            },
            xAxis: {
                title: {
                    text: 'On boarding steps'
                },
                categories:[],
                labels: {
                    formatter: function() {
                        return this.value +' %';
                    }
                },
            },
            yAxis: {
                title: {
                    text: 'Users percentage'
                },
                labels: {
                    formatter: function() {
                        return this.value +' %';
                    }
                },
            },
            series: this.#data
        });
    }
}
