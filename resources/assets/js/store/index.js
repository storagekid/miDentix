import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';
import ModelClass from '../classes/modelClass';
import TableClass from '../classes/tableClass';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        app: {
        },
        pages: {},
        modals: {},
        tables: {},
        forms: {},
        models: {},
        readiness: {
            modelsReady: false,
            formsReady: true,
        },
        newModel: {
            modal: false,
            id: null,
        },
        animationClasses: {
            'glitter-dentix': [],
        }
    },

    getters: {
        ready({readiness}) {
            for (let check in readiness) {
                if (!readiness[check]) {
                    return false;
                }
            }
            return true;
        }
    },

    actions: {
        // PAGES

        // MODALS
        
        // TABLES
        setTable({state,commit},{name, options, columns}) {
            Vue.set(state.tables, name, {});
            Vue.set(state.tables[name], 'options', options);
            Vue.set(state.tables[name], 'columns', columns);
            Vue.set(state.tables[name], 'rowsSelected', []);
            commit('tableSelectAll', name);
        },
        setTableClass({state,dispatch,commit},{name=null, options=null, columns=null}) {
            let temp = new TableClass({name:name,options:options,columns:columns});
            Vue.set(state.tables, temp.name, temp);
            Vue.set(state.tables[name], 'rowsSelected', []);

            // if (!state.models[name]) {
            //     commit('setModel', {name: name, items: {}});
            //     dispatch('fetchModels',[name]);
            // }

            axios.get('/api/clinics/table').then(({data}) => {
                state.tables[name].columns = data.columns;
            });
        },
        // MODELS
        showEdit({commit, state}, {payload}) {
            let model = payload.model;
            let relatedModel = payload.relatedModel;
            state.models[model].updating.state = true;
            let selected;
            if (relatedModel) {
                console.log('HERE');
                selected = state.models[relatedModel].modelToSave[model].filter(model => payload.ids.includes(model.id));                            
            } else {
                console.log('THERE');
                selected = state.models[model].items.filter(model => payload.ids.includes(model.id));            
            }
            commit('newModal', {name:'new-' + model + '-model', data:{'model':model , 'ids':payload.ids, items: selected, mode:'edit'}});                        
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
            console.log(headers);
            console.log(payload);
            axios.post('/api/'+name, payload, {headers})
                .then(({data}) => {
                    console.log('Created');
                    commit('addNewModel', {modelName: name, model: data.newmodel});
                    setTimeout(function() {
                        console.log('Moviiing');
                        Vue.scrollToElement(name+data.newmodel.id);
                        state.animationClasses["glitter-dentix"].push(data.newmodel.id); 
                    },1000);
                })
                .catch(({error}) => {
                    console.log(error);
                });            
        },
        updateModel({commit, state}, {name, model, hasFiles}) {
            let headers = {};
            let payload = model;
            let method = 'patch';
            if (hasFiles) {
                method = 'post';
                console.log('Update Has Files');
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
                for (let value of payload.values()) {
                    console.log(value);
                }
            };
            // console.log(headers);
            // console.log(payload);
            axios[method]('/api/'+name+'/'+model.id, payload, {headers})
                .then(({data}) => {
                    console.log('Updated');
                    commit('updateModel', {modelName: name, model: data.updatedModel});
                    setTimeout(function() {
                        console.log('Moviiing');
                        Vue.scrollToElement(name+data.updatedModel.id);
                        state.animationClasses["glitter-dentix"].push(data.updatedModel.id); 
                    },1000);
                })
                .catch(({error}) => {
                    console.log(error);
                });            
        },
        removeModels({commit, state}, {name,ids}) {
            for (let id of ids) {
                axios.delete('/api/'+name+'/'+id)
                .then((response) => {
                    console.log('Models deleted successfully');
                    commit('removeModel', {model: name, id:id});
                })
                .catch(({error}) => {
                    console.log('Error deleting');
                });
            };
            commit('hideModal',{name: 'delete-' + name + '-model'});
        },
        fetchModels({state,commit}, models) {
            let modelsToFetch = [];
            let modelsFetched = 0;
            for(let model of models) {
                if (!state.models[model]) {
                    commit('setModel', {name: model});
                    modelsToFetch.push(model);
                }
            }
            if (modelsToFetch.length) {
                commit('modelsNotReady');
                for(let model of modelsToFetch) {
                    axios.get('/api/'+model)
                    .then(data => {
                        if (data.data.model) {
                            let items = data.data.model;
                            commit('setItemsFetched', {name: model, items: items});
                            modelsFetched++;
                            // if (state.tables[model]) {
                            //     console.log('Selecting All Rows');
                            //     console.log(model);
                            //     commit('tableSelectAll', model);
                            // }
                        }
                        if (modelsToFetch.length == modelsFetched) {
                            commit('modelsReady');
                        }
                    })
                    .catch(error => {
                        console.log('Error fetching models');
                    });
                }
            }
        },
        setNewRelation({state, commit}, {name, relation, item}) {
            axios.post('/api/relations/?model='+name+'&relation='+relation, item)
            .then(({data}) => {
                let id = state.models[name].modelToSave[relation].length+'t'+1;
                console.log('ID: ' + id);
                data.relation['id'] = id;
                commit('setNewRelation', {'name': name, 'relation': relation, item: data.relation});
            })
        },
        updateRelation({state, commit}, {name, relation, item}) {
            axios.patch('/api/relations/'+item.id+'?model='+name+'&relation='+relation, item)
            .then(({data}) => {
                // console.log(data.relation);
                commit('updateRelation', {'name': name, 'relation': relation, model: data.relation});
            })
        },
        removeRelations({commit, state}, {name, relation, ids}) {
            let items = state.models[name].modelToSave[relation];
            let filtered = items.filter(item => ids.indexOf(item.id) === -1);
            commit('setRelation',{'name': name, 'relation': relation, 'items': filtered});
            commit('hideModal',{name: 'delete-' + relation + '-model'});
        },
        // USER
        fetchUser({commit}) {
            axios.get('/api/user')
                .then(({data}) => {
                    commit('setUser', data);
                })
        },
    },

    mutations: {
        // PAGES


        //MODALS
        newModal(state, {name,data}) {
            Vue.set(state.modals, name, data);
            Vue.set(state.modals[name], 'active', true);
        },
        hideModal(state,{name}) {
            state.modals[name].active = false;
        },
        destroyModal(state,{name}) {
            Vue.delete(state.modals, name);
        },
        //Table
        tableSelectAll(state, table) {
            for (let item of state.models[table].items) {
                state.tables[table].filtering.selected.push(item.id);
            }
        },
        setTable(state, model) {
            Vue.set(state.tables, model, {});
            Vue.set(state.tables[model], 'ready', true);
        },
        removeTable(state, model) {
            Vue.delete(state.tables, model);
        },
        // Forms
        setForm(state, {model, models, relations}) {
            Vue.set(state.forms, model, {});
            Vue.set(state.forms[model], 'ready', true);
            Vue.set(state.forms[model], 'relations', relations);
            Vue.set(state.forms[model], 'modelsNeeded', models);
        },
        destroyForm({forms}, {name}) {
            Vue.delete(forms, name);            
        },
        formsNotReady({readiness}) {
            readiness.formsReady = false;
        },
        formsReady({readiness}) {
            readiness.formsReady = true;
        },
        newRelationForm(state, {model, relation}) {
            Vue.set(state.forms[model]['relations'][relation], 'active', true);
        },
        hideRelationForm(state, {model, relation}) {
            state.forms[model]['relations'][relation].active = false;
        },
        //User
        setUser(state, user) {
            state.user = user;
        },
        // Model
        modelsReady({readiness}) {
            readiness.modelsReady = true;
        },
        modelsNotReady({readiness}) {
            readiness.modelsReady = false;
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
            // Vue.set(models[name].modelToSave[relation], [], item);
            models[name].modelToSave[relation].push(item);
        },
        updateRelation({models}, {name, relation , model}) {
            for (const [index, item] of models[name].modelToSave[relation].entries()) {
                if (item.id == model.id) {
                    console.log('Found!!!');
                    Vue.set(models[name].modelToSave[relation], index, model);
                    // models[name].modelToSave[relation][index] = model;
                }
            }
            // state.newModel.id = model.id;
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
        setItemsFetched({models}, {name, items}) {
            models[name].items = items;
        },
        selectModel({models}, {model,id}) {
            if (id == 'null') {
                models[model].itemSelected = null;
                models[model].idSelected = null;
                return false;
            }
            models[model].itemSelected = models[model].items.find(item => item.id === id);
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
        addNewModel(state, {modelName,model}) {
            state.models[modelName].items.push(model);
            state.newModel.id = model.id;
        },
        updateModel(state, {modelName,model}) {
            for (const [index, item] of state.models[modelName].items.entries()) {
                if (item.id == model.id) {
                    console.log('Found!!!');
                    state.models[modelName].items[index] = model;
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
    }
})