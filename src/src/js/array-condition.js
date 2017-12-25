window.PzCms.checkCondition = function (item, condition) {
    let i;
    let result   = true;
    let operator = condition[0];
    if (!operator) {
        for (let key in condition) {
            if (condition.hasOwnProperty(key)) {
                if (Array.isArray(condition[key])) {
                    if (condition[key].indexOf(item[key]) === -1) {
                        result = false;
                    }
                } else {
                    if (item[key] != condition[key]) {
                        result = false;
                    }
                }
            }
        }
    } else {
        switch (operator) {
            case 'and':
                for (i = 1; i < condition.length; i++) {
                    result = result && PzCms.checkCondition(item, condition[i]);
                }
                break;

            case 'or':
                result = false;
                for (i = 1; i < condition.length; i++) {
                    result = result || PzCms.checkCondition(item, condition[i]);
                }
                break;

            case 'not':
                result = !PzCms.checkCondition(item, condition[1]);
                break;

            case '<>':
            case '!=':
                result = item[condition[1]] != condition[2];
                break;

            case '>':
                result = item[condition[1]] > condition[2];
                break;

            case '>=':
                result = item[condition[1]] >= condition[2];
                break;

            case '<':
                result = item[condition[1]] < condition[2];
                break;

            case '<=':
                result = item[condition[1]] <= condition[2];
                break;

            case 'in':
                result = condition[2].indexOf(item[condition[1]]) !== -1;
                break;

            case 'not in':
                result = condition[2].indexOf(item[condition[1]]) === -1;
                break;
        }
    }

    return result;
};
