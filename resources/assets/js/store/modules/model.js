import ModelClass from '../../classes/modelClass';

const state = {
    models: {},
    newModel: {},
    newRelation: {},
    ready: false,
    animationClasses: {
        'glitter-dentix': [],
    }    
};
const getters = {
    selected(state) {
        let selectedModels = {};
        if (Object.keys(state.models).length ) {
            for (let model in state.models) {
                if (state.models[model].itemSelected) {
                    selectedModels[model] = state.models[model].items.find(item => item.id == state.models[model].itemSelected);
                }
            }
        }
        return selectedModels;
    }
};
const actions = {
    showEdit({commit, state}, {payload}) {
        let model = payload.model;
        let relatedModel = payload.relatedModel;
        state.models[model].updating.state = true;
        let selected;
        if (relatedModel) {
            selected = state.models[relatedModel].modelToSave[model].filter(model => payload.ids.includes(model.id));                            
        } else {
            selected = state.models[model].items.filter(model => payload.ids.includes(model.id));            
        }
        if (!payload.column) {
            payload['column'] = null;
        }
        commit('Modal/newModal', {name:'new-' + model + '-model', data:{'model':model , 'ids':payload.ids, items: selected, mode:payload.mode, fields:payload.column}}, { root: true });                        
    },
    createNewModel({commit, state}, {name,model,hasFiles}) {
        let headers = {};
        let payload = model;
        if (hasFiles) {
            headers['Content-Type'] = 'multipart/form-data';
            payload = new FormData();
            for (let key in model) {
                if (Array.isArray(model[key])) {
                    let json_arr = JSON.stringify(model[key]);
                    payload.append(key, json_arr);                                                   
                } else {
                    payload.append(key, model[key] ? model[key] : '');                        
                }
            }
            payload.append('file', model['design']);
        };
        axios.post('/api/'+name, payload, {headers})
            .then(({data}) => {
                commit('addNewModel', {modelName: name, model: data.newmodel});
                scrollToAndGlow(name+data.newmodel.id, data.newmodel.id, state, commit);
            })
            .catch((error) => {
                flash({
                    message: error.response.data.message, 
                    label: 'danger'
                  });
            });         
    },
    updateModel({commit, state}, {name, model, ids, hasFiles}) {
        let headers = {};
        let payload = model;
        let method = 'patch';
        if (hasFiles) {
            method = 'post';
            headers['Content-Type'] = 'multipart/form-data';
            payload = new FormData();
            payload.append('_method', 'PATCH');
            for (let key in model) {
                if (Array.isArray(model[key])) {
                    let json_arr = JSON.stringify(model[key]);
                    payload.append(key, json_arr);                                                   
                } else {
                    payload.append(key, model[key] ? model[key] : '');                        
                }
            }
            payload.append('file', model['design']);
        };
        for (let modelId of ids) {
            axios[method]('/api/'+name+'/'+modelId, payload, {headers})
                .then(({data}) => {
                    commit('updateModel', {modelName: name, model: data.updatedModel});
                    scrollToAndGlow(name+data.updatedModel.id,data.updatedModel.id, state, commit);
                })
                .catch(({error}) => {
                    // console.log(error);
                });
        }            
    },
    removeModels({commit, state}, {name,ids}) {
        for (let id of ids) {
            axios.delete('/api/'+name+'/'+id)
            .then(({data}) => {
                commit('removeModel',??{model: name, id:id});
                flash({
                    message: data.message ? data.message : name + 'eliminado correctamente.', 
                    label: 'success'
                });
            })
            .catch(({error}) => {
                // console.log('Error deleting');
            });
        };
        commit('Modal/hideModal',{name: 'delete-' + name + '-model'}, { root: true });
    },
    fetchModels({state,commit}, options = {models, ids:null, groupBy:null ,refresh:false}) {
        let modelsToFetch = [];
        let modelsFetched = 0;
        for(let model of options.models) {
            if (!state.models[model] ||??options.refresh) {
                commit('setModel', {name: model});
                modelsToFetch.push(model);
            }
        }
        if (modelsToFetch.length) {
            commit('modelsNotReady');
            for(let model of modelsToFetch) {
                let params = {};
                if (options.ids) {
                    params['ids'] = options.ids;
                }
                if (options.groupby) {
                    params['groupby'] = options.groupby;
                }
                axios({
                    url: '/api/'+model,
                    method: 'GET',
                    params: params
                  })
                .then(data => {
                    if (data.data.model) {
                        let items = data.data.model;
                        commit('setItemsFetched', {name: model, items: items});
                        modelsFetched++;
                    }
                    if (modelsToFetch.length == modelsFetched) {
                        commit('modelsReady');
                    }
                })
                .catch(error => {
                    // console.log('Error fetching models');
                });
            }
        }
    },
    fetchFilteredModels({state,commit, rootState}, options = {models, groupBy:null ,refresh:false, scoped:false}) {
        let modelsToFetch = [];
        let modelsFetched = 0;
        for(let model in options.models) {
            if (!state.models[model] ||??options.refresh) {
                // console.log('Refresh!!!!');
                commit('setModel', {name: model});
                modelsToFetch.push(model);
            }
        }
        if (modelsToFetch.length) {
            commit('modelsNotReady');
            for(let model of modelsToFetch) {
                // console.log('Model: ' + model);
                // console.log(options.models[model]);
                let params = {};
                if (options.models[model].ids) {
                    params['ids'] = options.models[model].ids;
                }
                if (options.models[model].clinic) {
                    params['clinic_id'] = options.models[model].clinic;
                }
                if (options.models[model].groupby) {
                    params['groupby'] = options.models[model].groupby;
                }
                if (options.scoped) {
                    if (rootState.Scope.clinics.selected != '-') {
                        params['clinic_id'] = rootState.Scope.clinics.selected;
                    } else if (rootState.Scope.counties.selected != '-') {
                        params['county_id'] = rootState.Scope.counties.selected;
                    } else if (rootState.Scope.states.selected != '-') {
                        params['state_id'] = rootState.Scope.states.selected;
                    } else if (rootState.Scope.countries.selected != '-') {
                        params['country_id'] = rootState.Scope.countries.selected;
                    } else {
                        params['scope'] = false;
                    }
                }
                axios({
                    url: '/api/'+model,
                    method: 'GET',
                    params: params
                  })
                // axios.get('/api/'+model+'?ids='+options.models[model].ids+'&groupby='+options.groupBy)
                .then(data => {
                    if (data.data.model) {
                        let items = data.data.model;
                        commit('setItemsFetched', {name: model, items: items});
                        modelsFetched++;
                        console.log('Model ' + model + ' fetched');
                        if (rootState.Scope[model]) {
                            if (rootState.Scope[model].selected) {
                                commit('selectModel', {'model': model, id: rootState.Scope[model].selected});
                            }
                        }
                    }
                    if (modelsToFetch.length == modelsFetched) {
                        commit('modelsReady');
                    }
                })
                .catch((error) => {
                    flash({
                        message: error.response.data.message, 
                        label: 'danger'
                      });
                });
            }
        }
    },
    setNewRelation({state, commit}, {name, relation, item}) {
        axios.post('/api/relations/?model='+name+'&relation='+relation, item)
        .then(({data}) => {
            // console.log('Here');
            // console.log(state.models[name].modelToSave);
            let id = state.models[name].modelToSave[relation].length+'t'+1;
            data.relation['id'] = id;
            commit('setNewRelation', {'name': name, 'relation': relation, item: data.relation});
            scrollToAndGlow(relation+data.relation.id,data.relation.id, state, commit);
        })
    },
    updateRelation({state, commit}, {name, relation, ids, item}) {
        for (let modelId of ids) {
            axios.patch('/api/relations/'+modelId+'?model='+name+'&relation='+relation, item)
            .then(({data}) => {
                if (data.relation.id != data.id) {
                    data.relation.id = data.id;
                }
                commit('updateRelation', {'name': name, 'relation': relation, model: data.relation});
                scrollToAndGlow(relation+data.relation.id,data.relation.id, state, commit);
            })
        }
    },
    updateGhostRelation({state, commit}, {name, relation, ids, modelToSave}) {
        for (let modelId of ids) {
            let relationToUpdate;
            for (const [index, oldModel] of state.models[name].modelToSave[relation].entries()) {
                if (oldModel.id == modelId) {
                    relationToUpdate = oldModel;
                    for (let field in modelToSave) {
                        relationToUpdate[field] = modelToSave[field];
                    }
                }
            }
            axios.patch('/api/relations/'+modelId+'?model='+name+'&relation='+relation, relationToUpdate)
            .then(({data}) => {
                if (data.relation.id != data.id) {
                    data.relation.id = data.id;
                }
                commit('updateRelation', {'name': name, 'relation': relation, model: data.relation});
                scrollToAndGlow(relation+data.relation.id,data.relation.id, state, commit);
            })
        }
    },
    removeRelations({commit, state}, {name, relation, ids}) {
        let items = state.models[name].modelToSave[relation];
        let filtered = items.filter(item => ids.indexOf(item.id) === -1);
        commit('setRelation',{'name': name, 'relation': relation, 'items': filtered});
        commit('Modal/hideModal',{name: 'delete-' + relation + '-model'}, { root: true });
    },
};
const mutations = {
    addIdToAnimate(state, id) {
		state.animationClasses["glitter-dentix"].push(id);      
    },
    cleanAnimations(state, animation) {
        state.animationClasses[animation] = []; 
    },
    modelsReady(state) {
        state.ready = true;
    },
    modelsNotReady(state) {
        state.ready = false;
    },
    modalNewReady({modalNew}) {
        modalNew.ready = true;
    },
    setModel({models}, {name}) {
        let temp = new ModelClass(name);            
        Vue.set(models, name, {});
        for (let prop in temp) {
            Vue.set(models[name], prop, temp[prop]);
        }
    },
    setNewRelation({models}, {name, relation, item}) {
        models[name].modelToSave[relation].push(item);
        Vue.set(state.newRelation, name+relation, {id: item.id});
    },
    deleteTempNewRelation({models}, {name, relation}) {
        Vue.delete(state.newRelation, relation+name);
    },
    updateRelation(state, {name, relation , model}) {
        for (const [index, item] of state.models[name].modelToSave[relation].entries()) {
            if (item.id == model.id) {
                Vue.set(state.models[name].modelToSave[relation], index, model);
                Vue.set(state.newRelation, name+relation, {id: item.id});
            }
        }
    },
    updateGhostRelation(state, {name, relation, ids, modelToSave}) {
        for (const [index, item] of state.models[name].modelToSave[relation].entries()) {
            if (ids.includes(item.id)) {
                for (let field in modelToSave) {
                    item[field] = modelToSave[field];
                }
                // Vue.set(state.models[name].modelToSave[relation], index, model);
                Vue.set(state.newRelation, name+relation, {id: item.id});
            }
        }
    },
    setRelation({models}, {name, relation, items}) {
        models[name].modelToSave[relation] = items;
    },
    restoreModelState({models}, {name}) {
        models[name].creating.state = false;
        models[name].destroying.state = false;
        models[name].updating.state = false;
        models[name].updating.items = [];
        models[name].modelToSave = {};
    },
    restoreNewIds(state, {model, relation}) {
        // if (state.newModel[model]) {
        //     state.newModel[model].ids = [];
        // }
        // if (relation) {
        //     Vue.delete(state.newRelation, relation+model);
        // }
    },
    setItemsFetched({models}, {name, items}) {
        models[name].items = items;
    },
    selectModel({models}, {model,id}) {
        if (id == 'null') {
            models[model].itemSelected = null;
            models[model].idSelected = null;
            return false;
        }
        models[model].itemSelected = id;
        // models[model].itemSelected = models[model].items.find(item => item.id == id);
    },
    modelToSaveBuilder({models}, {model, fields, item=null, relations}) {
        for (let field in fields) {
            Vue.set(
                models[model].modelToSave,
                fields[field].name,
                item ? item[field] : null,
            )
        }
        if (item) {
            Vue.set(
                models[model].modelToSave,
                'id',
                item.id ? item.id : null,
            ) 
        }
        for (let relation in relations) {
            if (item) {
                if (item[relation]) {
                    Vue.set(
                        models[model].modelToSave,
                        relation,
                        item[relation],
                    )
                }
            }
            else {
                Vue.set(
                    models[model].modelToSave,
                    relation,
                    [],
                )
            }
        }
    },
    addNewModel(state, {modelName, model}) {
        state.models[modelName].items.unshift(model);
        if (!state.newModel[modelName]) {
            Vue.set(state.newModel, modelName, {ids: [model.id]});
        } else {
            state.newModel[modelName].ids.push(model.id);
        }
        // state.newModel.id = model.id;
    },
    cleanNewModelId(state, {model, id}) {
        state.newModel[model].ids.splice(state.newModel[model].ids.indexOf(id), 1);
    },
    updateModel(state, {modelName, model}) {
        for (const [index, item] of state.models[modelName].items.entries()) {
            if (item.id == model.id) {
                Vue.set(state.models[modelName].items, index, model);
                // state.models[modelName].items[index] = model;
            }
        }
        state.newModel.id = model.id;
    },
    removeModel({models}, {model,id}) {
        let item = models[model].items.find((item) => item.id == id);
        models[model].items.splice(models[model].items.indexOf(item),1);
    },
    setOrderedItems({models}, {modelName, model}) {
        models[modelName].items = model;
    },
    setFileToModel({models}, {model, name, field}) {
        models[model].modelToSave[field] = name;
    },
    removeFile({models}, {model, file}) {
        models[model].modelToSave[file] = null;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}