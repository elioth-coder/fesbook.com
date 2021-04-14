function hidePanes() {
  const panes = document.querySelectorAll('.panel-pane');

  panes.forEach(pane => {
    let classNames = [...pane.getAttribute('class').split(/\s/), 'hidden'];
    classNames = [...new Set(classNames)];

    pane.setAttribute('class', classNames.join(" "))
  });
}

function deactivateButtons() {
  const activeClass = "text-blue-400 text-2xl border-blue-400 border-b-4".split(/\s/);
  const inActiveClass = "text-gray-400".split(/\s/);
  const buttons = document.querySelectorAll('.panel-btn');

  buttons.forEach(button => {
    let classNames = button.getAttribute('class').split(/\s/);
    classNames = classNames.filter(className => {
      return !activeClass.includes(className);
    });
    classNames = [...new Set([...classNames, ...inActiveClass])];

    button.setAttribute('class', classNames.join(" "));
  })
}

function activateButton(name) {
  const activeClass = "text-blue-400 text-2xl border-blue-400 border-b-4".split(/\s/);
  const inActiveClass = "text-gray-400".split(/\s/);
  let button = document.querySelector(`#${name}-btn`);
  let classNames = button.getAttribute('class').split(/\s/);
  inActiveClass.forEach(className => {
    let index = classNames.indexOf(className);
    classNames.splice(index, 1);
  });
  classNames = [...new Set([...classNames, ...activeClass])];

  button.setAttribute('class', classNames.join(" "));
}

function activatePane(name) {
  let pane = document.querySelector(`#${name}-pane`);
  let classNames = pane.getAttribute('class').split(/\s/);
  let index = classNames.indexOf('hidden');
  classNames.splice(index, 1);
  classNames = [...new Set(classNames)];

  pane.setAttribute('class', classNames.join(" "));
}

function activatePanel(name) {
  hidePanes();
  activatePane(name);
  deactivateButtons();
  activateButton(name);
}