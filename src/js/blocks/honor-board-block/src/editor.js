import { __ } from '@wordpress/i18n';
import {
  useBlockProps,
  InspectorControls,
} from '@wordpress/block-editor';
import {
  PanelBody,
  SelectControl,
  RadioControl,
  ToggleControl,
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEffect } from 'react';
import {
  DragDropContext,
  Droppable,
  Draggable,
} from '@hello-pangea/dnd';

export default function Edit({ attributes, setAttributes }) {
  let {
    term,
    order,
    manualOrder,
    showLaps,
    showDesc,
    showRegalia,
  } = attributes;

  const blockProps = useBlockProps();

  // 1) Загружаем все таксономии honor_board
  const terms = useSelect(
    (select) =>
      select('core').getEntityRecords('taxonomy', 'honor_board', {
        per_page: -1,
      }),
    []
  ) || [];

  // 1.a) Автовыбор первой доски при первом рендере
  useEffect(() => {
    if (!term && terms.length) {
      setAttributes({ term: terms[0].id });
    }
  }, [terms]);

  // 2) Загружаем людей по выбранной доске и сортировке через REST-параметры
  const people = useSelect(
    (select) => {
      if (!term) {
        return [];
      }
      const query = {
        per_page: -1,
        status: 'publish',
        honor_board: term,     // фильтр по таксономии в REST
      };

      if (order === 'manual' && manualOrder.length) {
        query.include = manualOrder;
        query.orderby = 'include';
      } else if (order === 'name_asc') {
        query.orderby = 'title';
        query.order   = 'ASC';
      } else if (order === 'laps_desc') {
        query.meta_key = 'person_laps';
        query.orderby  = 'meta_value_num';
        query.order    = 'DESC';
      }

      return select('core').getEntityRecords(
        'postType',
        'person',
        query
      );
    },
    [term, order, manualOrder]
  ) || [];

  // 3) При первом переходе в ручной режим инициируем manualOrder всеми ID
  useEffect(() => {
    if (
      order === 'manual' &&
      (!manualOrder || !manualOrder.length) &&
      people.length
    ) {
      setAttributes({
        manualOrder: people.map((p) => p.id),
      });
    }
  }, [order, people]);

  // 4) Обработчик перетаскивания
  const onDragEnd = (result) => {
    if (!result.destination) return;
    const current = manualOrder.length
      ? manualOrder
      : people.map((p) => p.id);
    const newOrder = Array.from(current);
    const [moved] = newOrder.splice(result.source.index, 1);
    newOrder.splice(result.destination.index, 0, moved);
    setAttributes({ manualOrder: newOrder });
  };

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Настройки доски почёта', 'biotropika')} initialOpen>
          <SelectControl
            label={__('Доска почёта', 'biotropika')}
            value={term}
            options={[
              { label: __('— Выберите —', 'biotropika'), value: 0 },
              ...terms.map((t) => ({ label: t.name, value: t.id })),
            ]}
            onChange={(val) => setAttributes({ term: parseInt(val, 10) })}
          />

          <RadioControl
            label={__('Сортировка', 'biotropika')}
            selected={order}
            options={[
              { label: __('Ручная', 'biotropika'), value: 'manual' },
              { label: __('По имени', 'biotropika'), value: 'name_asc' },
              { label: __('По кругам (убыванию)', 'biotropika'), value: 'laps_desc' },
            ]}
            onChange={(val) => setAttributes({ order: val })}
          />

          <ToggleControl
            label={__('Не отображать количество кругов', 'biotropika')}
            checked={!showLaps}
            onChange={() => setAttributes({ showLaps: !showLaps })}
          />

          <ToggleControl
            label={__('Не отображать пояснительный текст', 'biotropika')}
            checked={!showDesc}
            onChange={() => setAttributes({ showDesc: !showDesc })}
          />

          <ToggleControl
            label={__('Не отображать регалии', 'biotropika')}
            checked={!showRegalia}
            onChange={() => setAttributes({ showRegalia: !showRegalia })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <DragDropContext onDragEnd={onDragEnd}>
          <Droppable droppableId="honor-board">
            {(provided) => (
              <div
                ref={provided.innerRef}
                {...provided.droppableProps}
                className="honor-list-draggable"
              >
                {(manualOrder.length
                  ? manualOrder
                  : people.map((p) => p.id)
                ).map((personId, idx) => {
                  const person = people.find((p) => p.id === personId);
                  if (!person) return null;
                  return (
                    <Draggable
                      key={personId}
                      draggableId={String(personId)}
                      index={idx}
                    >
                      {(prov) => (
                        <div
                          ref={prov.innerRef}
                          {...prov.draggableProps}
                          {...prov.dragHandleProps}
                          className="honor-item"
                        >
                          {person.featured_media_url && (
                            <img
                              src={person.featured_media_url}
                              className="honor-item__photo"
                              alt=""
                            />
                          )}
                          <h6 className="honor-item__name">
                            {person.title.rendered}
                          </h6>
                          {showDesc && (
                            <p className="honor-item__desc">
                              {person.content.raw}
                            </p>
                          )}
                          {showRegalia && person._embedded?.['wp:term'] && (
                            <p className="honor-item__regalia">
                              {person._embedded['wp:term']
                                .find((g) => g.taxonomy === 'regalia')
                                ?.map((t) => t.name)
                                .join(', ')}
                            </p>
                          )}
                          {showLaps && person.meta?.person_laps && (
                            <p className="honor-item__laps">
                              {person.meta.person_laps}{' '}
                              {__('кругов', 'biotropika')}
                            </p>
                          )}
                        </div>
                      )}
                    </Draggable>
                  );
                })}
                {provided.placeholder}
              </div>
            )}
          </Droppable>
        </DragDropContext>
      </div>
    </>
  );
}
