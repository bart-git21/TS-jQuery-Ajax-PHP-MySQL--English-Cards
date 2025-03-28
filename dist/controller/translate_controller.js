import { originList } from "../model/origin_model.js";
import { TView } from "../view/translate_view.js";
import { TModel } from "../model/translate_model.js";
class TController {
    model;
    view;
    constructor(model, view) {
        this.model = model;
        this.view = view;
        this.model.subscribeToDisplaySentence((q, a) => this.view.sentence(q, a));
        this.model.subscribeToDisplayResult((number) => this.view.result(number));
        this.model.subscribeToDisplayProgress(this.view.updateProgress.bind(this.view));
        this.handleKeyListener();
        this.view.bindToDelay(this.model.updateDelay.bind(this.model));
        this.view.bindToStart(this.handleStart);
        this.view.bindToNextLevel(this.model.nextLevel.bind(this.model));
        this.view.bindToStop(this.model.stop.bind(this.model));
    }
    handleStart = async () => {
        this.model.motherList = originList.getShallowList();
        if (!this.model.motherList.length) {
            this.view.message("The list is empty!");
            return;
        }
        await this.model.start(this.view.getDelay.bind(this.view));
    };
    handleKeyListener() {
        this.view.subscribeToKeyup(this.model.updateDelay.bind(this.model), this.model.prev.bind(this.model), this.model.next.bind(this.model), this.model.delete.bind(this.model), this.handleStart);
    }
    stop() {
        this.view.stop();
        this.model.stop();
    }
    handleChangedList() {
        this.model.clear();
        this.view.message("The sentences are changed. Click to start!");
    }
}
function translateGame() {
    return new TController(new TModel(originList.getShallowList()), new TView());
}
const appTranslate = translateGame();
export { appTranslate };
//# sourceMappingURL=translate_controller.js.map