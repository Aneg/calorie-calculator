const findObjectById = (objects, id) => {
  return objects.find((el) => { return el.id === id })
};

const findIndexObjectById = (objects, id) => {
  return objects.findIndex((el) => { return el.id === id })
};

const dropOrUpdateObjectById = (objects, id, newObject = null) => {
  let key = findIndexObjectById(objects, id);
  if (key !== -1) {
    return newObject ? objects.splice(key, 1, newObject) : objects.splice(key, 1)
  }
  return []
};

const copyValue = (value) => {
  return JSON.parse(JSON.stringify(value))
};

const generateIdByObject = (newObjects, nextId) => {
  newObjects.map((el) => {
    if (!el.id) {
      el.id = nextId;
      nextId += 1
    }
    return el
  });
  return nextId
};

export { findObjectById, findIndexObjectById, dropOrUpdateObjectById, copyValue, generateIdByObject }
