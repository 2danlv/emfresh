const table_languageConfig = {
  paginate: {
    previous: '<i class="fas fa-left"></i>',
    next: '<i class="fas fa-right"></i>',
  },
  searchBuilder: {
    button: {
      0: '<i class="fas fa-filter"></i> Bộ lọc',
      _: '<i class="fas fa-filter"></i> Bộ lọc (%d)',
    },
    add: '<i class="fas fa-plus mr-8"></i> Thêm điều kiện',
    condition: "Chọn biểu thức",
    clearAll: "Xóa tất cả bộ lọc",
    delete: '<i class="fas fa-trash"></i>',
    deleteTitle: "Xóa lọc",
    data: "Chọn cột",
    //left: 'Left',
    //leftTitle: 'Left Title',
    logicAnd: "Và",
    logicOr: "Hoặc",
    //right: 'Right',
    //rightTitle: 'Right Title',
    title: {
      0: "Điều kiện lọc",
      //_: 'Điều kiện lọc (%d)',
    },
    value: "Giá trị",
    valueJoiner: "-",
    conditions: {
      date: {
        between: "Trong khoảng",
        empty: "Rỗng",
        equals: "Bằng",
        after: "Sau ngày",
        before: "Trước ngày",
        gt: "Lớn hơn",
        gte: "Lớn hơn bằng",
        lt: "Nhỏ hơn",
        lte: "Nhỏ hơn bằng",
        not: "Khác",
        notBetween: "Ngoài khoảng",
        notEmpty: "Không rỗng",
      },
      number: {
        between: "Trong khoảng",
        empty: "Rỗng",
        equals: "Bằng",
        gt: "Lớn hơn",
        gte: "Lớn hơn bằng",
        lt: "Nhỏ hơn",
        lte: "Nhỏ hơn bằng",
        not: "Khác",
        notBetween: "Ngoài khoảng",
        notEmpty: "Không rỗng",
      },
      string: {
        between: "Trong khoảng",
        empty: "Rỗng",
        equals: "Bằng",
        gt: "Lớn hơn",
        gte: "Lớn hơn bằng",
        lt: "Nhỏ hơn",
        lte: "Nhỏ hơn bằng",
        not: "Khác",
        notBetween: "Ngoài khoảng",
        notEmpty: "Không rỗng",
        contains: "Chứa",
        endsWith: "Kết thúc với",
        notContains: "Không chứa",
        notEndsWith: "Không kết thúc với",
        notStartsWith: "Không bắt đầu với",
        startsWith: "Bắt đầu với",
      },
    },
  },
};
const tagCondition = {
	"=": {
		conditionName: 'Bằng',
		init: function (that, fn, preDefined = null) {
			var el = $('<select/>')
				.addClass([that.classes.value, that.classes.input])
				.on('input', function () {
					fn(that, this);
				});
			// value is tag
			// if ($('.' + that.classes.data).val() == 6 && typeof list_tags == 'object') {
			if (typeof list_tags == 'object') {
				el.append(`<option selected hidden>Giá trị</option>`);
				list_tags.forEach((text) => {
					text = text.trim();
					value = stringToSlug(text);
					if (text != '') {
						el.append(`<option value="${value}">${text}</option>`);
					}
				});
			}
			if (preDefined !== null) {
				$(el).val(preDefined[0]);
			}
			return el;
		},
		inputValue: function (el) {
			return $(el[0]).val();
		},
		isInputValid: function (el, that) {
			return $(el[0]).val() && $(el[0]).val().length !== 0;
		},
		search: function (value, comparison) {
			if (typeof comparison == 'object' && comparison.length > 0) {
				return value != '' && comparison.filter(text => value.search(text) > -1).length > 0;
			}
			return value % comparison === 0;
		},
	},
	'!=': {
		conditionName: 'Khác',
		init: function (that, fn, preDefined = null) {
			return tagCondition['='].init(that, fn, preDefined);
		},
		inputValue: function (el) {
			return $(el[0]).val();
		},
		isInputValid: function (el, that) {
			return $(el[0]).val() && $(el[0]).val().length !== 0;
		},
		search: function (value, comparison) {
			return !tagCondition['='].search(value, comparison);
		},
	},
};